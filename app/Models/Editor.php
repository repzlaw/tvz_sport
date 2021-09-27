<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Editor extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'editor_role_id',
        'uuid',
        'name',
        'password',
        'security_answer',
        'security_question_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function passwordSecurity()
    {
        return $this->hasOne(EditorPasswordSecurity::class, 'editor_id');
    }

    /**
     * Get the competition the news was written for.
     */
    public function role()
    {
        return $this->belongsTo(EditorRole::class, 'editor_role_id');
    }
}
