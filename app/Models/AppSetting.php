<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $primaryKey = 'setting_id';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function subscriptionPrice(): int
    {
        return (int) static::query()
            ->where('key', 'subscription_price_monthly')
            ->value('value') ?: 10000;
    }

    public static function setSubscriptionPrice(int $price): void
    {
        static::query()->updateOrCreate(
            ['key' => 'subscription_price_monthly'],
            ['value' => (string) $price]
        );
    }
}
