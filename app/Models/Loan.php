<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'copy_id',
        'loan_date',
        'due_date',
        'return_date',
        'status',
        'fine_amount',
    ];

    protected $casts = [
        'loan_date' => 'datetime',
        'due_date' => 'datetime',
        'return_date' => 'datetime',
        'fine_amount' => 'decimal:2',
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function copy()
    {
        return $this->belongsTo(Copy::class);
    }

    // Acesso rápido ao livro através do exemplar
    public function book()
    {
        return $this->hasOneThrough(Book::class, Copy::class, 'id', 'id', 'copy_id', 'book_id');
    }
}