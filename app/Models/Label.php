<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = [
        'user_id',
        'name',
    ];


    /**
     * Eager Loading
     */
    protected $with = ['notes', 'todoGroups'];


    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function todoGroups()
    {
        return $this->hasMany(TodoGroup::class);
    }

    /**
     * Local Scopes
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Mutators
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower(trim($value));
    }
}