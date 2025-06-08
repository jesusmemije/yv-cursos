<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'event_category_id', 'id');
    }

    public function activeEvents()
    {
        return $this->hasMany(Event::class, 'event_category_id', 'id')->where('status', 1);
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid = Str::uuid()->toString();
            $model->slug = Str::slug($model->name, '-');
        });
    }
}
