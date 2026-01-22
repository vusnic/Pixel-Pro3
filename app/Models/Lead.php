<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'country_code',
        'website',
        'message',
        'source',
        'status',
    ];

    /**
     * Get the formatted phone number with country code.
     *
     * @return string
     */
    public function getFullPhoneAttribute()
    {
        return $this->country_code . ' ' . $this->phone;
    }
} 