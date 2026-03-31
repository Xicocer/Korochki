<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Application extends Model
{
    use Searchable;

    protected $fillable = [
        'user_id', 'course_id', 'start_date',
        'payment_method', 'status',
    ];

    protected $casts = [
        'start_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->id,
            'user_name' => $this->user->full_name,
            'user_phone' => $this->user->phone,
            'course_title' => $this->course->title,
            'status' => $this->status,
        ];
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
