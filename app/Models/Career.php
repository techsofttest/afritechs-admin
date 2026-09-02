<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;

    protected $table = 'careers';

    protected $fillable = [
        'title',
        'type',
        'description',
        'image',
        'location',
        'application_deadline',
        'application_url',
        'featured_status',
        'status',
    ];

    protected $casts = [
        'application_deadline' => 'date',
        'featured_status' => 'boolean',
        'status' => 'boolean',
    ];
}