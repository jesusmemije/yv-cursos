<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FinalProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'course_id',
        'user_id',
        'title',
        'description',
        'is_registered',
        'registered_at'
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'is_registered' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function submissions()
    {
        return $this->hasMany(FinalProjectSubmission::class);
    }

    public function isRegistered()
    {
        return $this->is_registered;
    }
}