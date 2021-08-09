<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuspensionHistory extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the policy.
     */
    public function policy()
    {
        return $this->belongsTo(BanPolicy::class,'policy_id');
    }

}
