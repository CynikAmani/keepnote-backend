<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'label_id',
        'title',
        'color',
        'is_pinned',
        'is_archived',
    ];

    
    /**
     * Enable Eager Loading
     */
    protected $with = ['todoItems'];


    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function label()
    {
        return $this->belongsTo(Label::class);
    }

    public function todoItems()
    {
        return $this->hasMany(TodoItem::class)->orderBy('position');
    }

    /**
     * Local Scopes
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeUnpinned($query)
    {
        return $query->where('is_pinned', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    /**
     * Accessors
     */
    public function getColorAttribute($value)
    {
        return strtolower($value);
    }

    public function getIsEmptyAttribute()
    {
        return $this->todoItems()->count() === 0;
    }

    /**
     * Mutators
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim($value);
    }

    public function setColorAttribute($value)
    {
        $this->attributes['color'] = strtolower(trim($value ?? 'white'));
    }
}