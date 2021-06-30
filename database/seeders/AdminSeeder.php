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
                'fname' => 'tvz',
                'lname' => 'tvz',
                'password' => bcrypt('12345678'),
            )
        );

        foreach ($admin as $value) {
            $user = Admin::updateOrCreate($value);
        }
    }
}
