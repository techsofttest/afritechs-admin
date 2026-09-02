<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'service_id',
        'title',
        'slug',
        'location',
        'image',
        'description',
        'meta_title',
        'meta_desc',
        'meta_key',
        'status',
        'is_flagship',
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_flagship' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Service
    |--------------------------------------------------------------------------
    */

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Project Images
    |--------------------------------------------------------------------------
    */

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class, 'project_id');
    }
}