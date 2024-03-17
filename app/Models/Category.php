<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        //Tambahkan field lain yang perlu diisi
    ];

    // Jika Anda memiliki relasi dengan model Post, tambahkan relasi di sini
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
