<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // 1. Wajib panggil ini
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory; // 2. Wajib pasang trait ini di dalam class agar fungsi factory() aktif

    // Kolom tabel yang diizinkan untuk diisi data secara massal
    protected $fillable = [
        'nama_varian',
        'stok',
        'harga',
    ];
}