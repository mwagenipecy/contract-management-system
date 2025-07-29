<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemSetting;

class SystemSettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            [
                'key' => 'notification_days_before_expiry',
                'value' => '30,7,3,1',
                'type' => 'string',
                'description' => 'Days before contract expiry to send notifications (comma-separated)',
            ],
            [
                'key' => 'penalty_rate_per_day',
                'value' => '50',
                'type' => 'integer',
                'description' => 'Daily penalty rate for late contract renewals',
            ],
            [
                'key' => 'penalty_type',
                'value' => 'daily',
                'type' => 'string',
                'description' => 'Penalty calculation type: daily or fixed',
            ],
            [
                'key' => 'auto_apply_penalties',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Automatically apply penalties for expired contracts',
            ],
            [
                'key' => 'email_notifications_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'description' => 'Enable email notifications',
            ],
            [
                'key' => 'sms_notifications_enabled',
                'value' => 'false',
                'type' => 'boolean',
                'description' => 'Enable SMS notifications',
            ],
            [
                'key' => 'company_name',
                'value' => 'Contract Management System',
                'type' => 'string',
                'description' => 'Company name for the system',
            ],
            [
                'key' => 'grace_period_days',
                'value' => '7',
                'type' => 'integer',
                'description' => 'Grace period in days before applying penalties',
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::create($setting);
        }
    }
}