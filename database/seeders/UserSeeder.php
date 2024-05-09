<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Mike Figaredo',
            'email' => 'mfigaredo@gmail.com',
            'password' => bcrypt('test123'),
        ]);

        User::factory(99)->create();
    }
}
