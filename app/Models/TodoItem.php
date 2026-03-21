<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model
{
    protected $fillable = [
        'todo_group_id',
        'task',
        'is_completed',
        'position',
    ];

    /**
     * Relationships
     */
    public function todoGroup()
    {
        return $this->belongsTo(TodoGroup::class);
    }

    /**
     * Accessors
     */
    public function getTaskAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Mutators
     */
    public function setTaskAttribute($value)
    {
        $this->attributes['task'] = trim($value);
    }

    public function setPositionAttribute($value)
    {
        $this->attributes['position'] = max(0, (int) $value);
    }
}