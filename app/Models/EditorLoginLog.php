<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EditorLoginLog extends Model
{
    use HasFactory;

    protected $guarded = [];


    /**
     * Get editor details.
     */
    public function editor()
    {
        return $this->belongsTo(Editor::class);
    }

}
