<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
    ['email' => 'trackforge30@gmail.com'],
    ['name' => 'Admin', 'password' => bcrypt('TrackForge '), 'is_admin' => true]
);

        Setting::firstOrCreate(['id' => 1], [
            'store_name' => 'TrackForge ',
            'whatsapp_number' => '923001234567',
            'free_delivery_threshold' => 2000,
            'delivery_charge' => 200,
            
        ]);

        $categories = [
            ['name' => 'RC Cars', 'emoji' => '🎮'],
            ['name' => 'Die-Cast', 'emoji' => '🏎️'],
            ['name' => 'Metal Cars', 'emoji' => '🔩'],
            ['name' => 'Baby Cars', 'emoji' => '👶'],
            ['name' => 'Race Tracks', 'emoji' => '🏁'],
            ['name' => 'Monster Trucks', 'emoji' => '🚛'],
            ['name' => 'Robot Cars', 'emoji' => '🤖'],
            ['name' => 'Electric Cars', 'emoji' => '⚡'],
        ];

        foreach ($categories as $cat) {
            $category = Category::firstOrCreate(['name' => $cat['name']], $cat);

            for ($i = 1; $i <= 4; $i++) {
                Product::firstOrCreate(
                    ['name' => $cat['name'] . " Model $i", 'category_id' => $category->id],
                    [
                        'category_id' => $category->id,
                        'brand' => 'Generic',
                        'price' => rand(800, 5000),
                        'old_price' => rand(0, 1) ? rand(5500, 8000) : null,
                        'description' => 'High quality ' . strtolower($cat['name']) . ' — bachon ke liye perfect gift.',
                        'specifications' => "Scale: 1:18\nMaterial: Alloy/Plastic\nAge: 3+ years",
                        'emoji' => $cat['emoji'],
                        'badge' => collect(['none', 'NEW', 'HOT', 'SALE'])->random(),
                        'rating' => rand(35, 50) / 10,
                        'is_bestseller' => (bool) rand(0, 1),
                        'is_new' => (bool) rand(0, 1),
                        'in_stock' => true,
                    ]
                );
            }
        }
    }
}
