<?php

namespace Database\Seeders;

use App\Models\EditorRole;
use Illuminate\Database\Seeder;

class EditorRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editor = array(
            array(
                'role' => 'editor',
            ),
            array(
                'role' => 'author',
            )
        );

        foreach ($editor as $value) {
            $role = EditorRole::updateOrCreate($value);
        }
    }
}
