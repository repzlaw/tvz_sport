<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumPost extends Model
{
    use HasFactory;

    protected $connection = 'mysql3';

    protected $guarded = [];

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    /**
     * Get the user that posted the comment.
     */
    public function user()
    {
        return $this->setConnection('mysql')->belongsTo(User::class, 'user_id');
    }
}
