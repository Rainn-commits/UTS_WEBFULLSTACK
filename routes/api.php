<?php

use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Http\Controllers\HarvestController;
use App\Http\Controllers\SalesController;

Route::get('/products', function() {
    return response()->json([
        'success' => true,
        'data' => Product::all()
    ]);
});

Route::post('/harvests/store', [HarvestController::class, 'store']);
Route::post('/sales/checkout', [SalesController::class, 'checkout']);
