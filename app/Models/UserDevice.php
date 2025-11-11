<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fingerprint',
        'device_name',
        'browser',
        'platform',
        'ip_address',
    ];
}
