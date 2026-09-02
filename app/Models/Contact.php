<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'address',
        'map_link',
        'phone',
        'email',
        'whatsapp',
        'opening_hours',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'youtube',
    ];
}