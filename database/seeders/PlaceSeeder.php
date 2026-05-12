<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Place;
use Illuminate\Database\Seeder;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        $places = [
            [
                'place_name' => 'Kafe Ruang Kerja Jogja',
                'category' => 'cafe',
                'address' => 'Jl. Kaliurang KM 5 No. 12, Sleman',
                'city' => 'Yogyakarta',
                'latitude' => -7.7628,
                'longitude' => 110.3804,
                'price_range' => '15000-40000',
                'opening_hours' => '08:00-22:00',
                'description' => 'Kafe dengan suasana tenang dan WiFi kencang, cocok untuk kerja seharian.',
                'noise_level' => 'tenang',
                'facilities' => ['wifi', 'stop_kontak', 'ac', 'parkir', 'toilet'],
            ],
            [
                'place_name' => 'Coworking Space Malioboro',
                'category' => 'coworking',
                'address' => 'Jl. Malioboro No. 45, Yogyakarta',
                'city' => 'Yogyakarta',
                'latitude' => -7.7925,
                'longitude' => 110.3656,
                'price_range' => '25000-75000',
                'opening_hours' => '07:00-23:00',
                'description' => 'Coworking space profesional di jantung kota Yogyakarta.',
                'noise_level' => 'sedang',
                'facilities' => ['wifi', 'stop_kontak', 'ac', 'parkir', 'loker', 'printer'],
            ],
            [
                'place_name' => 'Perpustakaan Kota Yogyakarta',
                'category' => 'perpustakaan',
                'address' => 'Jl. Suroto No. 9, Kotabaru, Yogyakarta',
                'city' => 'Yogyakarta',
                'latitude' => -7.7823,
                'longitude' => 110.3782,
                'price_range' => '0-0',
                'opening_hours' => '08:00-16:00',
                'description' => 'Perpustakaan umum dengan koleksi lengkap dan ruang baca yang nyaman.',
                'noise_level' => 'tenang',
                'facilities' => ['wifi', 'ac', 'toilet', 'musholla'],
            ],
            [
                'place_name' => 'Warung Kopi Produktif',
                'category' => 'cafe',
                'address' => 'Jl. Seturan Raya No. 22, Sleman',
                'city' => 'Yogyakarta',
                'latitude' => -7.7739,
                'longitude' => 110.4023,
                'price_range' => '10000-25000',
                'opening_hours' => '07:00-24:00',
                'description' => 'Warung kopi dengan banyak stop kontak dan harga ramah kantong mahasiswa.',
                'noise_level' => 'sedang',
                'facilities' => ['wifi', 'stop_kontak', 'parkir'],
            ],
            [
                'place_name' => 'The Study Hub Bandung',
                'category' => 'coworking',
                'address' => 'Jl. Dago No. 100, Bandung',
                'city' => 'Bandung',
                'latitude' => -6.8936,
                'longitude' => 107.6096,
                'price_range' => '30000-80000',
                'opening_hours' => '06:00-22:00',
                'description' => 'Hub produktivitas terbaik di Dago dengan pemandangan kota.',
                'noise_level' => 'tenang',
                'facilities' => ['wifi', 'stop_kontak', 'ac', 'parkir', 'ruang_privat', 'printer', 'loker'],
            ],
        ];

        foreach ($places as $data) {
            $facilityNames = $data['facilities'];
            unset($data['facilities']);

            $place = Place::create(array_merge($data, ['status' => 'active', 'data_completeness_score' => 80]));

            $facilityIds = Facility::whereIn('facility_name', $facilityNames)->pluck('facility_id');
            $place->facilities()->sync($facilityIds);
        }
    }
}
