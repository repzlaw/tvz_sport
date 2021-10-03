<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\UserRoleSeeder;
use Database\Seeders\EditorRoleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            EditorRoleSeeder::class,
            ConfigurationSeeder::class,
            SecurityQuestionsSeeder::class,
            UserRoleSeeder::class,
            UserMemberTypeSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
