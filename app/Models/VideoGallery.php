<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VideoGallery extends Model
{
    use HasFactory;

    protected $table = 'video_galleries';

    protected $fillable = [
        'title',
        'file_path',
        'file_size',
        'file_duration',
        'file_duration_second',
    ];

    public function lectures()
    {
        return $this->hasMany(Course_lecture::class, 'video_gallery_id');
    }

    protected static function booted()
    {
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
}
