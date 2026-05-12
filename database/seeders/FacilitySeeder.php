<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            ['facility_name' => 'wifi',        'label' => 'WiFi',          'icon_name' => 'wifi'],
            ['facility_name' => 'stop_kontak',  'label' => 'Stop Kontak',   'icon_name' => 'plug'],
            ['facility_name' => 'ac',           'label' => 'AC',            'icon_name' => 'snowflake'],
            ['facility_name' => 'parkir',       'label' => 'Parkir',        'icon_name' => 'car'],
            ['facility_name' => 'parkir_mobil', 'label' => 'Parkir Mobil',  'icon_name' => 'car'],
            ['facility_name' => 'parkir_motor', 'label' => 'Parkir Motor',  'icon_name' => 'bike'],
            ['facility_name' => 'tukang_parkir', 'label' => 'Tukang Parkir', 'icon_name' => 'user-check'],
            ['facility_name' => 'toilet',       'label' => 'Toilet',        'icon_name' => 'toilet'],
            ['facility_name' => 'musholla',     'label' => 'Musholla',      'icon_name' => 'mosque'],
            ['facility_name' => 'ruang_privat', 'label' => 'Ruang Privat',  'icon_name' => 'door-closed'],
            ['facility_name' => 'loker',        'label' => 'Loker',         'icon_name' => 'archive'],
            ['facility_name' => 'printer',      'label' => 'Printer',       'icon_name' => 'printer'],
        ];

        foreach ($facilities as $f) {
            Facility::firstOrCreate(['facility_name' => $f['facility_name']], $f);
        }
    }
}
