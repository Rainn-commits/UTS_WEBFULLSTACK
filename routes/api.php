<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HarvestController;
use App\Http\Controllers\Api\SalesController;
use App\Models\Product;

Route::get('/products', function() {
    return response()->json([
        'success' => true,
        'data' => Product::all()
    ]);
});

Route::post('/harvests/store', [HarvestController::class, 'store']);
Route::post('/sales/checkout', [SalesController::class, 'checkout']);
