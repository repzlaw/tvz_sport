<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerComment extends Model
{
    use HasFactory;
    
    protected $connection = 'mysql2';

    protected $guarded =[];

    /**
     * Get the user that posted the comment.
     */
    public function user()
    {
        return $this->setConnection('mysql')->belongsTo(User::class, 'user_id');
    }

}
