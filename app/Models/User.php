<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $with = ['labels'];

    // Relationships
    public function notes() { return $this->hasMany(Note::class); }
    public function todoGroups() { return $this->hasMany(TodoGroup::class); }
    public function labels() { return $this->hasMany(Label::class); }
    public function roles() { return $this->belongsToMany(Role::class)->withPivot('assigned_by')->withTimestamps(); }

    // Accessors
    public function getIsVerifiedAttribute() { return !is_null($this->email_verified_at); }
}