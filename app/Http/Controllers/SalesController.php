<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'kasir_id' => 'required|exists:users,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            $total_harga = 0;
            $items_to_process = [];

            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stok < $item['jumlah']) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Stok produk '{$product->nama_varian}' tidak mencukupi! Sisa stok saat ini: {$product->stok}"
                    ], 400);
                }

                $subtotal = $product->harga * $item['jumlah'];
                $total_harga += $subtotal;

                $items_to_process[] = [
                    'product' => $product,
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $subtotal
                ];
            }

            $sale = Sale::create([
                'kasir_id' => $validated['kasir_id'],
                'total_harga' => $total_harga
            ]);

            foreach ($items_to_process as $proc) {
                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'product_id' => $proc['product']->id,
                    'jumlah' => $proc['jumlah'],
                    'subtotal' => $proc['subtotal']
                ]);

                $proc['product']->decrement('stok', $proc['jumlah']);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi Penjualan Datu Coklat Berhasil Diproses!',
                'total_pembayaran' => $total_harga
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}
