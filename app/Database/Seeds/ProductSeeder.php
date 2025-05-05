<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        
        // Create 50 products
        for ($i = 0; $i < 50; $i++) {
            $this->db->table('products')->insert([
                'name' => $faker->words(3, true),
                'description' => $faker->paragraph(2),
                'price' => $faker->randomFloat(2, 10, 1000),
                'stock' => $faker->numberBetween(5, 100),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
    }
}
