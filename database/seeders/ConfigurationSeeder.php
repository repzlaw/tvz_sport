<?php

namespace Database\Seeders;

use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = array(
            array(
                'key' => 'captcha_enable',
                'value' => 0,
            ),
            array(
                'key' => 'captcha_site_key',
                'value' => null
            ),
            array(
                'key' => 'captcha_secret_key',
                'value' => null
            ),
            array(
                'key' => 'captcha_site_key_v3',
                'value' => null
            ),
            array(
                '_v3' => 'captcha_secret_key_v3',
                'value' => null
            ),
            array(
                'key' => 'captcha_login',
                'value' => 0
            ),
            array(
                'key' => 'captcha_register',
                'value' => 0
            ),
            array(
                'key' => 'comment_api_url',
                'value' => 'http://127.0.0.1:8000/api/'
            ),
            array(
                'key' => 'comment_api_key',
                'value' => null
            ),
        );

        foreach ($setting as $value) {
            $set = Configuration::updateOrCreate($value);
        }
    }
}
