<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use SoftDeletes; // Look for the 'deleted_at' column

    /**
     * The attributes that are mass assignable.
     * (security guard!)
     */
    protected $fillable = [
        'user_id',
        'label_id',
        'title',
        'content',
        'color',
        'is_pinned',
        'is_archived'
    ];
}
