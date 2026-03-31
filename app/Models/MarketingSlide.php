<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingSlide extends Model
{
    protected $fillable = ['title', 'description', 'image_path', 'is_active', 'order'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute(): string
    {
        return asset('storage/'.$this->image_path);
    }
}
