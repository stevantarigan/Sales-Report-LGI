<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Semen Portland',
                'sku' => 'BANG001',
                'description' => 'Semen Portland berkualitas tinggi untuk konstruksi bangunan',
                'price' => 75000,
                'cost_price' => 50000,
                'stock_quantity' => 200,
                'min_stock' => 20,
                'category' => 'Bahan Bangunan',
                'brand' => 'IndoSemen',
                'supplier' => 'PT. Semen Nusantara',
                'is_active' => true,
                'is_featured' => true,
                'specifications' => [
                    'jenis' => 'Portland Cement',
                    'berat' => '50kg',
                    'warna' => 'Abu-abu'
                ],
            ],
            [
                'name' => 'Bata Merah',
                'sku' => 'BANG002',
                'description' => 'Bata merah berkualitas untuk pembangunan dinding rumah',
                'price' => 1200,
                'cost_price' => 800,
                'stock_quantity' => 1000,
                'min_stock' => 100,
                'category' => 'Bahan Bangunan',
                'brand' => 'BataMakmur',
                'supplier' => 'CV. Batu Bata Sejahtera',
                'is_active' => true,
                'is_featured' => false,
                'specifications' => [
                    'ukuran' => '20x10x5 cm',
                    'bahan' => 'Tanah liat',
                    'warna' => 'Merah'
                ],
            ],
            [
                'name' => 'Cat Tembok Premium',
                'sku' => 'BANG003',
                'description' => 'Cat tembok tahan lama dengan warna cerah',
                'price' => 150000,
                'cost_price' => 90000,
                'stock_quantity' => 150,
                'min_stock' => 20,
                'category' => 'Bahan Bangunan',
                'brand' => 'ColorMax',
                'supplier' => 'PT. Warna Indah',
                'is_active' => true,
                'is_featured' => true,
                'specifications' => [
                    'warna' => 'Putih',
                    'volume' => '5 liter',
                    'jenis' => 'Acrylic'
                ],
            ],
            // Tambahkan produk bahan bangunan lain sesuai kebutuhan
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
