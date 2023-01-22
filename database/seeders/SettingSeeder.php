<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::firstOrCreate([
            'key' => 'site_title',
            'display_name' => 'Site Title',
            'value' => 'Laravel WireUi',
            'type' => 'text',
            'order' => 1
        ]);

        Setting::firstOrCreate([
            'key' => 'site_description',
            'display_name' => 'Site Description',
            'value' => 'Laravel WireUi Description',
            'type' => 'text',
            'order' => 2
        ]);
    }
}
