<?php

namespace Database\Seeders;

use App\Models\UserMemberType;
use Illuminate\Database\Seeder;

class UserMemberTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $member_type = array(
            array(
                'id' => 1,
                'type' => 'junior',
            ),
            array(
                'id' => 2,
                'type' => 'senior',
            )
        );

        foreach ($member_type as $value) {
            $type = UserMemberType::updateOrCreate($value);
        }
    }
}
