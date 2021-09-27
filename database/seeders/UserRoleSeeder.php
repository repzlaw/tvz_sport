<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = array(
            array(
                'id' => 1,
                'name' => 'user',
            ),
            array(
                'id' => 2,
                'name' => 'author',
            ),
            array(
                'id' => 3,
                'name' => 'editor',
            )
        );

        foreach ($user as $value) {
            $role = UserRole::updateOrCreate($value);
        }
    }
}
