<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Harvest;

class HarvestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'petani_id' => 'required|exists:users,id',
            'berat_kg' => 'required|numeric|min:1',
            'jenis_biji' => 'required|in:fermentasi,regular',
        ]);

        $harga_per_kg = ($validated['jenis_biji'] == 'fermentasi') ? 50000 : 35000;
        $total_bayar = $validated['berat_kg'] * $harga_per_kg;

        $harvest = Harvest::create([
            'petani_id' => $validated['petani_id'],
            'berat_kg' => $validated['berat_kg'],
            'jenis_biji' => $validated['jenis_biji'],
            'total_bayar' => $total_bayar,
            'tanggal_setor' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Setoran hasil panen kakao berhasil dicatat!',
            'data' => $harvest
        ], 201);
    }
}
