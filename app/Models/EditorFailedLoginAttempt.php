<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorFailedLoginAttempt extends Model
{
    use HasFactory;

    protected $guarded =[];

    public static function record($editor = null, $email, $ip, $browser_info)
    {
        return static::create([
            'editor_id' => is_null($editor) ? null : $editor->id,
            'email' => $email,
            'login_ip' => $ip,
            'browser_info' => json_encode($browser_info),
        ]);
    }
}
