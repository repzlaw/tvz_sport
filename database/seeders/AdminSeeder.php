<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = array(
            array(
                'email' => 'work@tvzcorp.com' ,
                'username' => 'tvzcorp',
                'uuid' => 'weuiiuf-27835-34sh5-3835',
                'name' => 'tvz',
                'password' => bcrypt('12345678'),
            )
        );

        foreach ($admin as $value) {
            $user = Admin::updateOrCreate($value);
        }
    }
}
