<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumCategory extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql3';

    protected $guarded = [];

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->diffForHumans();
    }

    /**
     * Get threads for the category.
     */
    public function forumThread()
    {
        return $this->hasMany(ForumThread::class,'forum_category_id');
    }

}
