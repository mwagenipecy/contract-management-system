{{-- resources/views/emails/promotion.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $promotion->title }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-top: 10px;
        }
        .badge-promotion { background-color: #10b981; color: white; }
        .badge-announcement { background-color: #3b82f6; color: white; }
        .badge-update { background-color: #f59e0b; color: white; }
        .badge-alert { background-color: #ef4444; color: white; }
        .badge-celebration { background-color: #8b5cf6; color: white; }
        
        .priority {
            margin-top: 5px;
        }
        .priority-urgent { color: #fee2e2; }
        .priority-high { color: #fef3c7; }
        .priority-medium { color: #e0f2fe; }
        .priority-low { color: #ecfdf5; }
        
        .content {
            padding: 40px;
        }
        .content p {
            margin-bottom: 16px;
            font-size: 16px;
            line-height: 1.7;
        }
        .content p:last-child {
            margin-bottom: 0;
        }
        .greeting {
            font-size: 18px;
            color: #4f46e5;
            margin-bottom: 20px;
        }
        .attachments {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 20px;
            margin-top: 30px;
        }
        .attachments h3 {
            margin: 0 0 15px 0;
            font-size: 16px;
            color: #374151;
        }
        .attachment-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            padding: 8px;
            background-color: white;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }
        .attachment-item:last-child {
            margin-bottom: 0;
        }
        .attachment-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            color: #6b7280;
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #6b7280;
        }
        .footer a {
            color: #4f46e5;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .company-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }
        .social-links {
            margin-top: 15px;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #6b7280;
            text-decoration: none;
        }
        
        /* Responsive */
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            .header, .content, .footer {
                padding: 20px;
            }
            .header h1 {
                font-size: 24px;
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #1f2937;
            }
            .container {
                background-color: #374151;
            }
            .content {
                color: #f9fafb;
            }
            .footer {
                background-color: #111827;
                color: #d1d5db;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <h1>{{ $promotion->title }}</h1>
            <div class="badge badge-{{ $promotion->type }}">
                {{ ucfirst($promotion->type) }}
            </div>
            @if($promotion->priority !== 'medium')
            <div class="priority priority-{{ $promotion->priority }}">
                <strong>{{ ucfirst($promotion->priority) }} Priority</strong>
            </div>
            @endif
        </div>

        {{-- Content --}}
        <div class="content">
            <div class="greeting">
                Hello {{ $employee->name }},
            </div>
            
            <div>
                {!! nl2br(e($promotion->content)) !!}
            </div>

            {{-- Attachments --}}
            @if($promotion->attachments && count($promotion->attachments) > 0)
            <div class="attachments">
                <h3>📎 Attachments</h3>
                @foreach($promotion->attachments as $attachment)
                <div class="attachment-item">
                    <svg class="attachment-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 00-5.656-5.656l-6.586 6.586a6 6 0 108.486 8.486L20.5 13"></path>
                    </svg>
                    <span>{{ $attachment['name'] }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>
                This {{ strtolower($promotion->type) }} was sent to you as part of our internal communications.
            </p>
            
            @if($promotion->start_date && $promotion->end_date)
            <p>
                <strong>Valid from:</strong> {{ $promotion->start_date->format('M d, Y') }} 
                <strong>to</strong> {{ $promotion->end_date->format('M d, Y') }}
            </p>
            @endif
            
            <p>
                Sent on {{ $promotion->sent_at ? $promotion->sent_at->format('M d, Y \a\t g:i A') : now()->format('M d, Y \a\t g:i A') }}
            </p>

            <div class="company-info">
                <p><strong>{{ config('app.name', 'Company Name') }}</strong></p>
                <p> Human Resources Department<br>
                    {{ config('company.address', 'Company Address') }}<br>
                    {{ config('company.phone', 'Phone Number') }} | {{ config('company.email', 'hr@company.com') }}
                </p>
                
                @if(isset($unsubscribeUrl))
                <p>
                    <small>
                        Don't want to receive these emails? 
                        <a href="{{ $unsubscribeUrl }}">Unsubscribe here</a>
                    </small>
                </p>
                @endif
            </div>

            <div class="social-links">
                <a href="{{ config('company.website', '#') }}">Website</a>
                <a href="{{ config('company.linkedin', '#') }}">LinkedIn</a>
                <a href="{{ config('company.facebook', '#') }}">Facebook</a>
            </div>
        </div>
    </div>

    {{-- Tracking Pixel for Email Opens --}}
    <img src="{{ route('promotions.track-open', ['promotion' => $promotion->id, 'employee' => $employee->id]) }}" 
         width="1" height="1" style="display:none;" alt="">
</body>
</html>