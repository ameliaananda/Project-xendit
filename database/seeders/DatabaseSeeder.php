<?php
 
namespace Database\Seeders;
 
// ✅ Wajib ada: import semua Model yang digunakan
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
 
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Semua kode ada di DALAM method run()
 
        // Buat akun Admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@toko.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);
 
        // Buat akun Customer demo
        User::create([
            'name'     => 'amel',
            'email'    => 'amel@gmail.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
        ]);
 
        // Buat produk sample
        $products = [
            ['name' => 'Kemeja Batik Premium',    'price' => 250000, 'stock' => 50,
             'description' => 'Kemeja batik motif klasik, bahan katun halus.'],
            ['name' => 'Sepatu Sneakers Casual',  'price' => 450000, 'stock' => 30,
             'description' => 'Sepatu sneakers kekinian, sol karet anti slip.'],
            ['name' => 'Tas Ransel Laptop 15"', 'price' => 320000, 'stock' => 25,
             'description' => 'Tas ransel multifungsi, bahan waterproof.'],
            ['name' => 'Jam Tangan Analog',       'price' => 185000, 'stock' => 40,
             'description' => 'Jam tangan analog elegan, tali kulit.'],
            ['name' => 'Kacamata Sunglasses UV400','price' => 120000, 'stock' => 60,
             'description' => 'Kacamata hitam pelindung UV400.'],
            ['name' => 'Dompet Kulit Pria',       'price' => 95000,  'stock' => 45,
             'description' => 'Dompet kulit slim minimalis.'],
        ];
 
        foreach ($products as $p) {
            Product::create($p);
        }
    }
}
