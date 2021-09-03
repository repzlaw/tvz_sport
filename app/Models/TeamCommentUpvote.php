<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamCommentUpvote extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $guarded =[];
}
