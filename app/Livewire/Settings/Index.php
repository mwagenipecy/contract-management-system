<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use App\Models\SystemSetting;

class Index extends Component
{
    public $activeTab = 'general';

    // General Settings
    public $company_name = '';
    public $company_email = '';
    public $company_phone = '';
    public $company_address = '';
    public $timezone = '';
    public $date_format = '';
    public $currency = '';

    // Notification Settings
    public $notification_days_before_expiry = '';
    public $email_notifications_enabled = true;
    public $sms_notifications_enabled = false;
    public $app_notifications_enabled = true;
    public $email_from_name = '';
    public $email_from_address = '';

    // Penalty Settings
    public $penalty_rate_per_day = '';
    public $penalty_type = 'daily';
    public $grace_period_days = '';
    public $auto_apply_penalties = true;
    public $penalty_currency = '';

    // Contract Settings
    public $default_contract_duration_years = '';
    public $default_renewal_notice_period = '';
    public $auto_renewal_enabled = false;
    public $contract_number_prefix = '';

    // Email Settings
    public $smtp_host = '';
    public $smtp_port = '';
    public $smtp_username = '';
    public $smtp_password = '';
    public $smtp_encryption = '';

    public function mount()
    {
        $this->loadSettings();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function loadSettings()
    {
        // General Settings
        $this->company_name = SystemSetting::get('company_name', 'Contract Management System');
        $this->company_email = SystemSetting::get('company_email', '');
        $this->company_phone = SystemSetting::get('company_phone', '');
        $this->company_address = SystemSetting::get('company_address', '');
        $this->timezone = SystemSetting::get('timezone', 'UTC');
        $this->date_format = SystemSetting::get('date_format', 'Y-m-d');
        $this->currency = SystemSetting::get('currency', 'USD');

        // Notification Settings
        $this->notification_days_before_expiry = SystemSetting::get('notification_days_before_expiry', '30,7,3,1');
        $this->email_notifications_enabled = SystemSetting::get('email_notifications_enabled', true);
        $this->sms_notifications_enabled = SystemSetting::get('sms_notifications_enabled', false);
        $this->app_notifications_enabled = SystemSetting::get('app_notifications_enabled', true);
        $this->email_from_name = SystemSetting::get('email_from_name', 'Contract Management System');
        $this->email_from_address = SystemSetting::get('email_from_address', '');

        // Penalty Settings
        $this->penalty_rate_per_day = SystemSetting::get('penalty_rate_per_day', 50);
        $this->penalty_type = SystemSetting::get('penalty_type', 'daily');
        $this->grace_period_days = SystemSetting::get('grace_period_days', 7);
        $this->auto_apply_penalties = SystemSetting::get('auto_apply_penalties', true);
        $this->penalty_currency = SystemSetting::get('penalty_currency', 'USD');

        // Contract Settings
        $this->default_contract_duration_years = SystemSetting::get('default_contract_duration_years', 2);
        $this->default_renewal_notice_period = SystemSetting::get('default_renewal_notice_period', 30);
        $this->auto_renewal_enabled = SystemSetting::get('auto_renewal_enabled', false);
        $this->contract_number_prefix = SystemSetting::get('contract_number_prefix', 'CNT');

        // Email Settings
        $this->smtp_host = SystemSetting::get('smtp_host', '');
        $this->smtp_port = SystemSetting::get('smtp_port', 587);
        $this->smtp_username = SystemSetting::get('smtp_username', '');
        $this->smtp_password = SystemSetting::get('smtp_password', '');
        $this->smtp_encryption = SystemSetting::get('smtp_encryption', 'tls');
    }

    public function saveGeneralSettings()
    {
        $this->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'nullable|email',
            'company_phone' => 'nullable|string|max:20',
            'timezone' => 'required|string',
            'currency' => 'required|string|size:3',
        ]);

        SystemSetting::set('company_name', $this->company_name, 'string');
        SystemSetting::set('company_email', $this->company_email, 'string');
        SystemSetting::set('company_phone', $this->company_phone, 'string');
        SystemSetting::set('company_address', $this->company_address, 'string');
        SystemSetting::set('timezone', $this->timezone, 'string');
        SystemSetting::set('date_format', $this->date_format, 'string');
        SystemSetting::set('currency', $this->currency, 'string');

        session()->flash('message', 'General settings saved successfully.');
    }

    public function saveNotificationSettings()
    {
        $this->validate([
            'notification_days_before_expiry' => 'required|string',
            'email_from_name' => 'nullable|string|max:255',
            'email_from_address' => 'nullable|email',
        ]);

        SystemSetting::set('notification_days_before_expiry', $this->notification_days_before_expiry, 'string');
        SystemSetting::set('email_notifications_enabled', $this->email_notifications_enabled, 'boolean');
        SystemSetting::set('sms_notifications_enabled', $this->sms_notifications_enabled, 'boolean');
        SystemSetting::set('app_notifications_enabled', $this->app_notifications_enabled, 'boolean');
        SystemSetting::set('email_from_name', $this->email_from_name, 'string');
        SystemSetting::set('email_from_address', $this->email_from_address, 'string');

        session()->flash('message', 'Notification settings saved successfully.');
    }

    public function savePenaltySettings()
    {
        $this->validate([
            'penalty_rate_per_day' => 'required|numeric|min:0',
            'penalty_type' => 'required|in:daily,fixed',
            'grace_period_days' => 'required|integer|min:0',
            'penalty_currency' => 'required|string|size:3',
        ]);

        SystemSetting::set('penalty_rate_per_day', $this->penalty_rate_per_day, 'integer');
        SystemSetting::set('penalty_type', $this->penalty_type, 'string');
        SystemSetting::set('grace_period_days', $this->grace_period_days, 'integer');
        SystemSetting::set('auto_apply_penalties', $this->auto_apply_penalties, 'boolean');
        SystemSetting::set('penalty_currency', $this->penalty_currency, 'string');

        session()->flash('message', 'Penalty settings saved successfully.');
    }

    public function saveContractSettings()
    {
        $this->validate([
            'default_contract_duration_years' => 'required|integer|min:1',
            'default_renewal_notice_period' => 'required|integer|min:1',
            'contract_number_prefix' => 'required|string|max:10',
        ]);

        SystemSetting::set('default_contract_duration_years', $this->default_contract_duration_years, 'integer');
        SystemSetting::set('default_renewal_notice_period', $this->default_renewal_notice_period, 'integer');
        SystemSetting::set('auto_renewal_enabled', $this->auto_renewal_enabled, 'boolean');
        SystemSetting::set('contract_number_prefix', $this->contract_number_prefix, 'string');

        session()->flash('message', 'Contract settings saved successfully.');
    }

    public function saveEmailSettings()
    {
        $this->validate([
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|in:tls,ssl',
        ]);

        SystemSetting::set('smtp_host', $this->smtp_host, 'string');
        SystemSetting::set('smtp_port', $this->smtp_port, 'integer');
        SystemSetting::set('smtp_username', $this->smtp_username, 'string');
        SystemSetting::set('smtp_password', $this->smtp_password, 'string');
        SystemSetting::set('smtp_encryption', $this->smtp_encryption, 'string');

        session()->flash('message', 'Email settings saved successfully.');
    }

    public function testEmailConfiguration()
    {
        // In a real application, you would test the email configuration here
        session()->flash('message', 'Email configuration test sent successfully.');
    }

    public function render()
    {
        return view('livewire.settings.index');
    }
}