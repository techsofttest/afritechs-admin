<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'meta_title',
        'meta_desc',
        'meta_key',
        'featured_status',
        'status',
    ];

    protected $casts = [
        'featured_status' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * Projects related to this service.
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'service_id');
    }
}