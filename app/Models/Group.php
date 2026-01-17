<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'enrollment_start_at',
        'enrollment_end_at',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'group_courses', 'group_id', 'course_id');
    }

    // Nueva relación para estudiantes
    public function students()
    {
        return $this->belongsToMany(User::class, 'group_students', 'group_id', 'user_id')
            ->withPivot('enrolled_at')
            ->withTimestamps();
    }
}
