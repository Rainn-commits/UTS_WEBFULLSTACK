<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class HarvestAndSalesApiTest extends TestCase
{
    use RefreshDatabase;

    // 1. Menguji Ambil Data Produk (Index)
    public function test_index_products_data() 
    {
        $response = $this->get('/api/products');
        $response->assertStatus(200);
    }

    // 2. Menguji Simpan Data Panen (Store)
    public function test_stores_harvest_data()
    {
        // Masukkan data dummy ke tabel users sebagai petani (ID: 1)
        DB::table('users')->insertOrIgnore([
            'id' => 1,
            'name' => 'Petani Tiruan',
            'email' => 'petani@datucokelat.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $dataPanen = [
            'petani_id' => 1,
            'berat_kg' => 15.5,
            'jenis_biji' => 'fermentasi'
        ];

        $response = $this->postJson('/api/harvests/store', $dataPanen);
        $this->assertTrue(in_array($response->getStatusCode(), [200, 201]));
    }

    // 3. Menguji Transaksi Pembelian/Penjualan (Checkout)
    public function test_sales_checkout_data()
    {
        // Masukkan data dummy ke tabel users sebagai kasir (ID: 2)
        DB::table('users')->insertOrIgnore([
            'id' => 2,
            'name' => 'Kasir Tiruan',
            'email' => 'kasir@datucokelat.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('products')->insertOrIgnore([
            [
                'id' => 1, 
                'nama_varian' => 'Cokelat Premium', 
                'stok' => 100,
                'harga' => 25000, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'id' => 2, 
                'nama_varian' => 'Cokelat Susu', 
                'stok' => 50,
                'harga' => 15000, 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);

        $dataSales = [
            'kasir_id' => 2,
            'items' => [
                ['product_id' => 1, 'jumlah' => 2],
                ['product_id' => 2, 'jumlah' => 1]
            ]
        ];

        $response = $this->postJson('/api/sales/checkout', $dataSales);
        $this->assertTrue(in_array($response->getStatusCode(), [200, 201]));
    }
}