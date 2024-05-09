<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Celulares y Tablets',
                'icon' => '<i class="fas fa-mobile-alt"></i>',
            ],
            [
                'name' => 'TV, audio y video',
                'icon' => '<i class="fas fa-tv"></i>',
            ],
            [
                'name' => 'Consola y Videojuegos',
                'icon' => '<i class="fas fa-gamepad"></i>',
            ],
            [
                'name' => 'Computación',
                'icon' => '<i class="fas fa-laptop"></i>',
            ],
            [
                'name' => 'Moda',
                'icon' => '<i class="fas fa-tshirt"></i>',
            ],
        ];
        $faker = \Faker\Factory::create();
        foreach($categories as $category) {
            $category['slug'] = Str::slug($category['name']); 
            // $category['image'] = 'categories/' . $faker->image('public/storage/categories', 640, 480, '', false, true, $category['name']);
            // $category['image'] = '';
            $categoryN = Category::factory(1)->create($category)->first();

            $brands = Brand::factory(4)->create();
            foreach($brands as $brand) {
                $brand->categories()->attach($categoryN->id);
            }
        }



    }
}
