<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'store_name', 'whatsapp_number', 'free_delivery_threshold',
        'delivery_charge', 'announcement',
    ];

    public static function current(): Setting
    {
        return static::firstOrCreate(['id' => 1]);
    }
}
