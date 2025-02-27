<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $setting = [
            'app_title' => 'EC Static Exploerers',
            'email' => 'explore@ecstaticexplorers.com',
            'mobile' => '8910845933',
            'whatsapp_number' => '9836155825',
            'location' => 'Premises no. D-206, Mondal Ganthi, Arjunpur, Kaikhali, North Dumdum, West Bengal, India. Kolkata -700052',
            
        ];
        Setting::factory()->create($setting);
    }
}
