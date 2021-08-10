<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminFailedLoginAttempt extends Model
{
    use HasFactory;

    protected $guarded =[];

    public static function record($admin = null, $email, $ip, $browser_info)
    {
        return static::create([
            'admin_id' => is_null($admin) ? null : $admin->id,
            'email' => $email,
            'login_ip' => $ip,
            'browser_info' => json_encode($browser_info),
        ]);
    }
}
