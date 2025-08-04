<?php

// app/Http/Integration/Beem/BeemSMSController.php
namespace App\Http\Integration\Beem;

use App\Http\Integration\Beem\Constants;
use App\Models\PromotionLog;
use Illuminate\Support\Facades\Log;

class BeemSMSController
{
    /**
     * Send SMS to a single recipient
     */
    static function send($phone, $message, $client_id = null, $report_id = null)
    {
        $api_key = Constants::API_KEY;
        $secret_key = Constants::SECRET_KEY;

        // Validate credentials
        if (!$api_key || !$secret_key) {
            $error = 'Beem API credentials not configured properly';
            Log::error($error, [
                'has_api_key' => !empty($api_key),
                'has_secret_key' => !empty($secret_key)
            ]);
            return [
                'success' => false,
                'error' => $error,
                'message' => 'SMS configuration error'
            ];
        }

        // Clean phone number
        $phone = self::cleanPhoneNumber($phone);
        
        // Validate phone number after cleaning
        if (!$phone || !preg_match('/^255[6-9]\d{8}$/', $phone)) {
            $error = 'Invalid phone number format: ' . $phone;
            Log::error($error, ['original_phone' => func_get_args()[0]]);
            return [
                'success' => false,
                'error' => $error,
                'message' => 'Invalid phone number'
            ];
        }

        // Validate message
        if (empty(trim($message))) {
            $error = 'Message cannot be empty';
            Log::error($error);
            return [
                'success' => false,
                'error' => $error,
                'message' => 'Empty message'
            ];
        }

        Log::info('Attempting to send SMS via Beem', [
            'phone' => $phone,
            'client_id' => $client_id,
            'report_id' => $report_id,
            'message_length' => strlen($message)
        ]);

        // Use a more standard sender_id or get from constants
        $sender_id = Constants::SENDER_ID; // or Constants::SENDER_ID if you have one configured

        $postData = [
            'source_addr' => $sender_id,
            'encoding' => 0,
            'schedule_time' => '',
            'message' => trim($message),
            'recipients' => [
                [
                    'recipient_id' => $client_id ?? 1,
                    'dest_addr' => $phone
                ]
            ]
        ];

        $url = Constants::BASE_URL;

        // Initialize cURL
        $ch = curl_init();
        
        // Set cURL options
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode("$api_key:$secret_key"),
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE)
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        // Handle cURL errors
        if ($curlError) {
            $errorMsg = "cURL Error: $curlError";
            Log::error("SMS cURL failed for {$phone}", [
                'curl_error' => $curlError,
                'phone' => $phone
            ]);

            self::logFailedAttempt($report_id, $phone, $message, $errorMsg, null);

            return [
                'success' => false,
                'error' => $errorMsg,
                'message' => 'Network error occurred'
            ];
        }

        // Parse response
        $responseData = json_decode($response, true);
        
        // Enhanced logging
        Log::info('Beem API Response', [
            'phone' => $phone,
            'http_code' => $httpCode,
            'response_data' => $responseData,
            'raw_response' => $response,
            'request_payload' => $postData
        ]);

        // Handle different HTTP status codes
        switch ($httpCode) {
            case 200:
            case 201:
                // Success - check response content
                $isSuccess = self::isResponseSuccessful($responseData);
                
                if ($isSuccess) {
                    Log::info("SMS sent successfully to {$phone}", [
                        'response' => $responseData,
                        'client_id' => $client_id,
                        'report_id' => $report_id
                    ]);

                    self::logSuccessfulAttempt($report_id, $phone, $message, $responseData);

                    return [
                        'success' => true,
                        'response' => $responseData,
                        'message' => 'SMS sent successfully',
                        'request_id' => $responseData['request_id'] ?? null
                    ];
                } else {
                    $errorMessage = self::extractErrorMessage($responseData);
                    Log::error("SMS API returned error for {$phone}", [
                        'error_message' => $errorMessage,
                        'response' => $responseData
                    ]);

                    self::logFailedAttempt($report_id, $phone, $message, $errorMessage, $responseData);

                    return [
                        'success' => false,
                        'error' => $errorMessage,
                        'response' => $responseData,
                        'message' => 'SMS sending failed'
                    ];
                }
                break;

            case 400:
                $errorMsg = "Bad Request - Invalid request format or parameters";
                if ($responseData) {
                    $errorMsg .= ": " . self::extractErrorMessage($responseData);
                }
                break;

            case 401:
                $errorMsg = "Unauthorized - Invalid API credentials";
                break;

            case 403:
                $errorMsg = "Forbidden - Access denied";
                break;

            case 429:
                $errorMsg = "Too Many Requests - Rate limit exceeded";
                break;

            case 500:
                $errorMsg = "Internal Server Error - Beem API error";
                break;

            default:
                $errorMsg = "HTTP Error: {$httpCode}";
                if ($responseData) {
                    $errorMsg .= " - " . self::extractErrorMessage($responseData);
                }
        }

        Log::error("SMS failed to send to {$phone}", [
            'error' => $errorMsg,
            'http_code' => $httpCode,
            'response' => $responseData,
            'request_payload' => $postData
        ]);

        self::logFailedAttempt($report_id, $phone, $message, $errorMsg, $responseData);

        return [
            'success' => false,
            'error' => $errorMsg,
            'http_code' => $httpCode,
            'response' => $responseData,
            'message' => 'SMS sending failed'
        ];
    }

    /**
     * Check if API response indicates success
     */
    private static function isResponseSuccessful($responseData)
    {
        if (!is_array($responseData)) {
            return false;
        }

        // Check for common error indicators
        if (isset($responseData['code']) && $responseData['code'] !== 200) {
            return false;
        }
        
        if (isset($responseData['successful']) && $responseData['successful'] === false) {
            return false;
        }
        
        if (isset($responseData['status']) && strtolower($responseData['status']) === 'error') {
            return false;
        }

        // If we have recipients data, check individual status
        if (isset($responseData['recipients']) && is_array($responseData['recipients'])) {
            foreach ($responseData['recipients'] as $recipient) {
                if (isset($recipient['status']) && strtolower($recipient['status']) === 'failed') {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Extract error message from response
     */
    private static function extractErrorMessage($responseData)
    {
        if (!is_array($responseData)) {
            return 'Unknown error - Invalid response format';
        }

        // Try different possible error message fields
        $errorFields = ['message', 'error', 'error_message', 'description', 'detail'];
        
        foreach ($errorFields as $field) {
            if (isset($responseData[$field]) && !empty($responseData[$field])) {
                return $responseData[$field];
            }
        }

        // Check in recipients array
        if (isset($responseData['recipients']) && is_array($responseData['recipients'])) {
            foreach ($responseData['recipients'] as $recipient) {
                if (isset($recipient['error']) && !empty($recipient['error'])) {
                    return $recipient['error'];
                }
            }
        }

        return 'Unknown API error';
    }

    /**
     * Log successful SMS attempt
     */
    private static function logSuccessfulAttempt($report_id, $phone, $message, $responseData)
    {
        if (!$report_id) return;

        try {
            PromotionLog::create([
                'promotion_id' => $report_id,
                'type' => 'sms',
                'recipient' => $phone,
                'message' => $message,
                'status' => 'sent',
                'response_data' => json_encode($responseData),
                'sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to log successful SMS delivery', [
                'error' => $e->getMessage(),
                'report_id' => $report_id
            ]);
        }
    }

    /**
     * Log failed SMS attempt
     */
    private static function logFailedAttempt($report_id, $phone, $message, $errorMessage, $responseData)
    {
        if (!$report_id) return;

        try {
            PromotionLog::create([
                'promotion_id' => $report_id,
                'type' => 'sms',
                'recipient' => $phone,
                'message' => $message,
                'status' => 'failed',
                'error_message' => $errorMessage,
                'response_data' => $responseData ? json_encode($responseData) : null,
                'sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to log SMS failure', [
                'error' => $e->getMessage(),
                'report_id' => $report_id
            ]);
        }
    }

    /**
     * Send SMS to multiple recipients (batch)
     */
    static function sendToMany($message, $recipients, $campaign_id = null)
    {
        if (empty($recipients)) {
            Log::warning('No recipients provided for batch SMS');
            return [];
        }

        $results = [];
        $batchSize = 50; // Reduced batch size to avoid API limits
        $batches = array_chunk($recipients, $batchSize);

        Log::info('Starting batch SMS sending', [
            'total_recipients' => count($recipients),
            'batch_count' => count($batches),
            'batch_size' => $batchSize,
            'campaign_id' => $campaign_id
        ]);

        foreach ($batches as $batchIndex => $batch) {
            $recipientArray = [];
            
            foreach ($batch as $recipient) {
                $phone = is_array($recipient) ? $recipient['phone'] : $recipient;
                $client_id = is_array($recipient) ? ($recipient['client_id'] ?? ($batchIndex * $batchSize + count($recipientArray) + 1)) : ($batchIndex * $batchSize + count($recipientArray) + 1);
                
                $cleanPhone = self::cleanPhoneNumber($phone);
                if ($cleanPhone && preg_match('/^255[6-9]\d{8}$/', $cleanPhone)) {
                    $recipientArray[] = [
                        'recipient_id' => $client_id,
                        'dest_addr' => $cleanPhone
                    ];
                } else {
                    Log::warning('Skipping invalid phone number in batch', [
                        'original' => $phone,
                        'cleaned' => $cleanPhone
                    ]);
                }
            }

            if (empty($recipientArray)) {
                Log::warning("Batch $batchIndex has no valid recipients");
                continue;
            }

            Log::info("Processing batch $batchIndex", [
                'batch_size' => count($recipientArray)
            ]);

            $result = self::sendBatch($message, $recipientArray, $campaign_id);
            $results[] = $result;

            // Delay between batches to avoid rate limiting
            if ($batchIndex < count($batches) - 1) {
                sleep(1); // 1 second delay
            }
        }

        // Calculate totals
        $totalSent = array_sum(array_column($results, 'sent_count'));
        $totalFailed = array_sum(array_column($results, 'failed_count'));

        Log::info('Batch SMS sending completed', [
            'total_sent' => $totalSent,
            'total_failed' => $totalFailed,
            'campaign_id' => $campaign_id
        ]);

        return [
            'batches' => $results,
            'summary' => [
                'total_recipients' => count($recipients),
                'total_sent' => $totalSent,
                'total_failed' => $totalFailed,
                'success_rate' => count($recipients) > 0 ? round(($totalSent / count($recipients)) * 100, 2) : 0
            ]
        ];
    }

    /**
     * Send batch SMS using Beem API
     */
    private static function sendBatch($message, $recipients, $campaign_id = null)
    {
        $api_key = Constants::API_KEY;
        $secret_key = Constants::SECRET_KEY;
        $sender_id = 'INFO'; // or Constants::SENDER_ID

        if (empty(trim($message))) {
            return [
                'success' => false,
                'sent_count' => 0,
                'failed_count' => count($recipients),
                'error' => 'Message cannot be empty'
            ];
        }

        $postData = [
            'source_addr' => $sender_id,
            'encoding' => 0,
            'schedule_time' => '',
            'message' => trim($message),
            'recipients' => $recipients
        ];

        $url = Constants::BASE_URL;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode("$api_key:$secret_key"),
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode($postData, JSON_UNESCAPED_UNICODE)
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);
        $sentCount = 0;
        $failedCount = 0;

        // Determine success/failure
        if ($httpCode == 200 && !$error && self::isResponseSuccessful($responseData)) {
            $sentCount = count($recipients);
            $status = 'sent';
        } else {
            $failedCount = count($recipients);
            $status = 'failed';
        }

        // Log individual results if campaign_id is provided
        if ($campaign_id) {
            foreach ($recipients as $recipient) {
                try {
                    PromotionLog::create([
                        'promotion_id' => $campaign_id,
                        'type' => 'sms',
                        'recipient' => $recipient['dest_addr'],
                        'message' => $message,
                        'status' => $status,
                        'error_message' => $status === 'failed' ? ($error ?: self::extractErrorMessage($responseData)) : null,
                        'response_data' => json_encode($responseData),
                        'sent_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    Log::warning('Failed to log batch SMS delivery', [
                        'error' => $e->getMessage(),
                        'recipient' => $recipient['dest_addr']
                    ]);
                }
            }
        }

        if ($httpCode == 200 && !$error && self::isResponseSuccessful($responseData)) {
            Log::info("Batch SMS sent successfully", [
                'batch_size' => count($recipients),
                'response' => $responseData
            ]);
            return [
                'success' => true,
                'sent_count' => $sentCount,
                'failed_count' => 0,
                'response' => $responseData
            ];
        } else {
            $errorMsg = $error ?: self::extractErrorMessage($responseData) ?: "HTTP Error: {$httpCode}";
            Log::error("Batch SMS failed", [
                'error' => $errorMsg,
                'http_code' => $httpCode,
                'batch_size' => count($recipients),
                'response' => $responseData,
                'request_payload' => $postData
            ]);
            return [
                'success' => false,
                'sent_count' => 0,
                'failed_count' => $failedCount,
                'error' => $errorMsg,
                'response' => $responseData
            ];
        }
    }

    /**
     * Clean and format phone number
     */
    private static function cleanPhoneNumber($phone)
    {
        if (empty($phone)) {
            return null;
        }

        // Remove all non-numeric characters except +
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Handle different Tanzanian number formats
        if (preg_match('/^0[6-9]\d{8}$/', $phone)) {
            // Convert 0XXXXXXXXX to 255XXXXXXXXX
            $phone = '255' . substr($phone, 1);
        } elseif (preg_match('/^[6-9]\d{8}$/', $phone)) {
            // Convert XXXXXXXXX to 255XXXXXXXXX
            $phone = '255' . $phone;
        } elseif (preg_match('/^255[6-9]\d{8}$/', $phone)) {
            // Already in correct format 255XXXXXXXXX
            // Keep as is
        } elseif (preg_match('/^\+255[6-9]\d{8}$/', $phone)) {
            // Convert +255XXXXXXXXX to 255XXXXXXXXX (remove +)
            $phone = substr($phone, 1);
        } else {
            // Try to extract valid number pattern
            if (preg_match('/255([6-9]\d{8})/', $phone, $matches)) {
                $phone = '255' . $matches[1];
            } elseif (preg_match('/([6-9]\d{8})/', $phone, $matches)) {
                $phone = '255' . $matches[1];
            }
        }
        
        // Final validation
        if (!preg_match('/^255[6-9]\d{8}$/', $phone)) {
            Log::warning('Invalid phone number format after cleaning', [
                'original' => func_get_args()[0],
                'cleaned' => $phone
            ]);
            return null;
        }
        
        return $phone;
    }

    /**
     * Check SMS balance
     */
    static function checkBalance()
    {
        $api_key = Constants::API_KEY;
        $secret_key = Constants::SECRET_KEY;

        if (!$api_key || !$secret_key) {
            return [
                'success' => false,
                'error' => 'API credentials not configured'
            ];
        }

        // Updated balance endpoint URL - verify with Beem documentation
        $url = 'https://apisms.beem.africa/v1/balance';

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode("$api_key:$secret_key"),
                'Content-Type: application/json',
                'Accept: application/json'
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        Log::info('Balance check response', [
            'http_code' => $httpCode,
            'response' => $responseData,
            'error' => $error
        ]);

        if ($httpCode == 200 && !$error) {
            return [
                'success' => true,
                'data' => $responseData
            ];
        } else {
            return [
                'success' => false,
                'error' => $error ?: 'Balance check failed',
                'http_code' => $httpCode,
                'response' => $responseData
            ];
        }
    }

    /**
     * Get delivery report for sent SMS
     */
    static function getDeliveryReport($requestId)
    {
        $api_key = Constants::API_KEY;
        $secret_key = Constants::SECRET_KEY;

        if (!$api_key || !$secret_key || !$requestId) {
            return [
                'success' => false,
                'error' => 'Missing required parameters'
            ];
        }

        // Updated delivery report endpoint - verify with Beem documentation
        $url = "https://apisms.beem.africa/v1/dlr/{$requestId}";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Basic ' . base64_encode("$api_key:$secret_key"),
                'Content-Type: application/json',
                'Accept: application/json'
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if ($httpCode == 200 && !$error) {
            return [
                'success' => true,
                'data' => $responseData
            ];
        } else {
            return [
                'success' => false,
                'error' => $error ?: 'Delivery report failed',
                'http_code' => $httpCode,
                'response' => $responseData
            ];
        }
    }
}