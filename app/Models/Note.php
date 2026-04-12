<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Note extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'label_id',
        'title',
        'content',
        'color',
        'is_pinned',
        'is_archived',
    ];

    /**
     * Eager load lightweight relations
     */
    protected $with = ['label'];

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

    /**
     * Local Scopes
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    /**
     * Accessors
     */
    public function getColorAttribute($value)
    {
        return strtolower($value);
    }

    /**
     * Mutators
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = trim($value);
    }

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = $value ? trim($value) : null;
    }

    public function setColorAttribute($value)
    {
        $this->attributes['color'] = strtolower(trim($value ?? 'white'));
    }
}