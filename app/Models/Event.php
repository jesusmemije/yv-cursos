<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'details',
        'image',
        'location',
        'start',
        'end',
        'time_zone',
        'status',
        'event_category_id'
    ];

    protected $dates = [
        'start',
        'end',
        'created_at',
        'updated_at'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'event_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'event_tags');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getImagePathAttribute()
    {
        return $this->image ?? 'uploads/default/event.png';
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid = Str::uuid()->toString();
            $model->creator_user_id = auth()->id();
            $model->slug = Str::slug($model->title, '-');
            $model->status = auth()->user()->is_admin() ? 1 : 0;
        });
    }
}
