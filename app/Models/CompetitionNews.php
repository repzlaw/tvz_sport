<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionNews extends Model
{
    use HasFactory;

    /**
     * Get the user that posted the news.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    /**
     * Get the competition the news was written for.
     */
    public function competition()
    {
        return $this->belongsTo(Competitions::class);
    }
}
