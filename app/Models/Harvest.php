<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harvest extends Model
{
    use HasFactory;

    protected $fillable = [
        'petani_id',
        'berat_kg',
        'jenis_biji',
        'total_bayar',
        'tanggal_setor',
    ];
}