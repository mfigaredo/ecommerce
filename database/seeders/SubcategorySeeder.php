<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategories = [
            // Celulares y Tablets
            [
                'category_id' => 1,
                'name' => 'Celulares y Smartphones',
                'color' => true,
            ],
            [
                'category_id' => 1,
                'name' => 'Accesorios para Celulares',
            ],
            [
                'category_id' => 1,
                'name' => 'Smartwatches',
            ],
            // TV Audio y Video
            [
                'category_id' => 2,
                'name' => 'TV y Audio',
                // 'color' => true,
            ],
            [
                'category_id' => 2,
                'name' => 'Audios',
            ],
            [
                'category_id' => 2,
                'name' => 'Audio para autos',
            ],
            // Consola y Videojuegos
            [
                'category_id' => 3,
                'name' => 'Xbox',
                // 'color' => true,
            ],
            [
                'category_id' => 3,
                'name' => 'Playstation',
            ],
            [
                'category_id' => 3,
                'name' => 'Videojuegos para PC',
            ],
            [
                'category_id' => 3,
                'name' => 'Nintendo',
            ],
            // Computación
            [
                'category_id' => 4,
                'name' => 'Portátiles',
                // 'color' => true,
            ],
            [
                'category_id' => 4,
                'name' => 'PC Escritorio',
            ],
            [
                'category_id' => 4,
                'name' => 'Almacenamiento',
            ],
            [
                'category_id' => 4,
                'name' => 'Accesorios computadora',
            ],
            // Moda
            [
                'category_id' => 5,
                'name' => 'Mujeres',
                'color' => true,
                'size' => true,
            ],
            [
                'category_id' => 5,
                'name' => 'Hombres',
                'color' => true,
                'size' => true,
            ],
            [
                'category_id' => 5,
                'name' => 'Lentes',
            ],
            [
                'category_id' => 5,
                'name' => 'Relojes',
            ],
        ];
        $faker = \Faker\Factory::create();
        foreach($subcategories as $subcategory) {
            $subcategory['slug'] = Str::slug($subcategory['name']);
            // $subcategory['image'] = 'subcategories/' . $faker->image('public/storage/subcategories', 640, 480, '', false, false, $subcategory['name']);
            // $subcategory['image'] = '';
            Subcategory::factory(1)->create($subcategory);
        }
    }
}
