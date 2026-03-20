<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Course extends Model
{
    use Searchable;

    protected $fillable = ['title', 'description'];

    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
