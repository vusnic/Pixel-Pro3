<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'category',
        'technologies',
        'client_name',
        'project_url',
        'completion_date',
        'highlights',
        'order',
        'featured',
        'status'
    ];

    protected $casts = [
        'completion_date' => 'date',
        'featured' => 'boolean',
        'order' => 'integer',
        'highlights' => 'array'
    ];

    public function getTechnologiesArrayAttribute()
    {
        return $this->technologies ? explode(',', $this->technologies) : [];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}
