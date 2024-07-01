<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'books_id');
    }
}
