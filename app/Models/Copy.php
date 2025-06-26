<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copy extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'patrimony_code',
        'status',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relacionamentos
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function loan()
    {
        return $this->hasOne(Loan::class); // Um exemplar pode ter apenas um empréstimo ativo por vez
    }
}