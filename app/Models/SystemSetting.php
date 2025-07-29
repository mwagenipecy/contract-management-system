<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    // Static methods for easy access
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return static::castValue($setting->value, $setting->type);
    }

    public static function set($key, $value, $type = 'string', $description = null)
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) ? json_encode($value) : $value,
                'type' => $type,
                'description' => $description,
            ]
        );
    }

    public static function has($key)
    {
        return static::where('key', $key)->exists();
    }

    public static function forget($key)
    {
        return static::where('key', $key)->delete();
    }

    public static function getAllSettings()
    {
        return static::pluck('value', 'key')->mapWithKeys(function ($value, $key) {
            $setting = static::where('key', $key)->first();
            return [$key => static::castValue($value, $setting->type ?? 'string')];
        });
    }

    // Cast value to appropriate type
    private static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'json':
            case 'array':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    // Accessor for casted value
    public function getCastedValueAttribute()
    {
        return static::castValue($this->value, $this->type);
    }

    // Common settings shortcuts
    public static function getNotificationDays()
    {
        $days = static::get('notification_days_before_expiry', '30,7,3,1'); // Uses getAllSettings if needed
        return array_map('intval', explode(',', $days));
    }

    public static function getPenaltyRate()
    {
        return static::get('penalty_rate_per_day', 50);
    }

    public static function getPenaltyType()
    {
        return static::get('penalty_type', 'daily');
    }

    public static function getGracePeriod()
    {
        return static::get('grace_period_days', 7);
    }

    public static function isEmailNotificationEnabled()
    {
        return static::get('email_notifications_enabled', true);
    }

    public static function isSmsNotificationEnabled()
    {
        return static::get('sms_notifications_enabled', false);
    }

    public static function shouldAutoApplyPenalties()
    {
        return static::get('auto_apply_penalties', true);
    }
}