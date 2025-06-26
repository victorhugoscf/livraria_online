<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'author',
        'publisher',
        'publication_year',
        'edition',
        'genre',
        'language',
        'pages',
        'total_copies',
        'available_copies',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relacionamentos
    public function copies()
    {
        return $this->hasMany(Copy::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}