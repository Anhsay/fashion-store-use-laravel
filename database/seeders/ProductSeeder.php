<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'name' => 'Áo thun nam',
                'description' => 'Áo thun cotton cao cấp',
                'price' => 199000,
                'image_url' => 'https://via.placeholder.com/150',
                'category' => 'Áo thun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Quần jean nữ',
                'description' => 'Quần jean co giãn thoải mái',
                'price' => 299000,
                'image_url' => 'https://via.placeholder.com/150',
                'category' => 'Quần jean',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
