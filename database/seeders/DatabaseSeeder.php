<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            Admin::class,
            CategorySeeder::class,
            MenuSeeder::class,
            TableSeeder::class,
            UserDemoSeeder::class,
            // tambahkan seeder lain jika perlu
        ]);
        Menu::create([
        'name' => 'Pajak 10%',
        'sku' => 'TAX10',
        'price' => 2000,  // Pajak tetap per order
        'category_id' => 1,  // Sesuaikan dengan kategori yang ada
        'image' => 'default_tax_image.jpg',  // Gambar placeholder
    ]);
    }
}
