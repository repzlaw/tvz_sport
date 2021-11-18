<?php

namespace App\Models;

// use Carbon\Carbon;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsComment extends Model
{
    use HasFactory;

    //protected $connection = 'mysql2';

    protected $guarded =[];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y'
      ];

    /**
     * Get the user that posted the comment.
     */
    public function user()
    {
        return $this->setConnection('mysql')->belongsTo(User::class, 'user_id');
    }

    public function getCreatedAtAttribute($value){
       return Carbon::parse($value)->diffForHumans();
    }
}
