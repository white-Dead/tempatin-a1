<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Place;
use App\Models\PlaceMenuItem;
use App\Models\PlaceMenuItemPhoto;
use App\Models\PlaceOperatingHour;
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
                'facilities' => ['wifi', 'stop_kontak', 'ac', 'parkir', 'parkir_mobil', 'parkir_motor', 'tukang_parkir', 'toilet'],
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
                'facilities' => ['wifi', 'stop_kontak', 'ac', 'parkir', 'parkir_mobil', 'parkir_motor', 'loker', 'printer'],
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
                'facilities' => ['wifi', 'stop_kontak', 'parkir', 'parkir_motor', 'tukang_parkir'],
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
                'facilities' => ['wifi', 'stop_kontak', 'ac', 'parkir', 'parkir_mobil', 'parkir_motor', 'ruang_privat', 'printer', 'loker'],
            ],
            [
                'place_name' => 'Kopi Teduh Gejayan',
                'category' => 'cafe',
                'address' => 'Jl. Affandi No. 18, Gejayan, Sleman',
                'city' => 'Yogyakarta',
                'latitude' => -7.7762,
                'longitude' => 110.3891,
                'price_range' => '12000-35000',
                'opening_hours' => '09:00-23:00',
                'description' => 'Kafe tenang dengan meja panjang, stop kontak di banyak titik, dan parkir motor yang luas.',
                'noise_level' => 'tenang',
                'facilities' => ['wifi', 'stop_kontak', 'parkir', 'parkir_motor', 'toilet'],
            ],
            [
                'place_name' => 'Ruang Fokus Seturan',
                'category' => 'coworking',
                'address' => 'Jl. Seturan Raya No. 88, Sleman',
                'city' => 'Yogyakarta',
                'latitude' => -7.7688,
                'longitude' => 110.4098,
                'price_range' => '20000-65000',
                'opening_hours' => '08:00-22:00',
                'description' => 'Coworking ringkas untuk kerja harian dengan AC, WiFi, ruang privat, printer, dan musholla.',
                'noise_level' => 'tenang',
                'facilities' => ['wifi', 'stop_kontak', 'ac', 'musholla', 'toilet', 'ruang_privat', 'printer'],
            ],
            [
                'place_name' => 'Nasi Sela Produktif',
                'category' => 'restoran',
                'address' => 'Jl. Babarsari No. 41, Sleman',
                'city' => 'Yogyakarta',
                'latitude' => -7.7794,
                'longitude' => 110.4135,
                'price_range' => '10000-30000',
                'opening_hours' => '10:00-21:00',
                'description' => 'Restoran santai untuk diskusi kelompok, lengkap dengan musholla, toilet, dan tukang parkir.',
                'noise_level' => 'ramai',
                'facilities' => ['wifi', 'musholla', 'toilet', 'parkir', 'parkir_motor', 'tukang_parkir'],
            ],
            [
                'place_name' => 'Perpus Mini Condongcatur',
                'category' => 'perpustakaan',
                'address' => 'Jl. Anggajaya No. 7, Condongcatur, Sleman',
                'city' => 'Yogyakarta',
                'latitude' => -7.7515,
                'longitude' => 110.3966,
                'price_range' => '0-0',
                'opening_hours' => '08:00-17:00',
                'description' => 'Ruang baca kecil dengan suasana sunyi, AC, WiFi, toilet, dan area parkir motor.',
                'noise_level' => 'tenang',
                'facilities' => ['wifi', 'ac', 'toilet', 'parkir', 'parkir_motor'],
            ],
            [
                'place_name' => 'Kedai Transit Jakal',
                'category' => 'cafe',
                'address' => 'Jl. Kaliurang KM 8 No. 15, Sleman',
                'city' => 'Yogyakarta',
                'latitude' => -7.7339,
                'longitude' => 110.3834,
                'price_range' => '8000-25000',
                'opening_hours' => '07:00-01:00',
                'description' => 'Kedai semi-terbuka untuk kerja malam dengan stop kontak, parkir mobil, motor, dan tukang parkir.',
                'noise_level' => 'sedang',
                'facilities' => ['wifi', 'stop_kontak', 'parkir', 'parkir_mobil', 'parkir_motor', 'tukang_parkir', 'toilet'],
            ],
            [
                'place_name' => 'Workpod Cihampelas',
                'category' => 'coworking',
                'address' => 'Jl. Cihampelas No. 120, Bandung',
                'city' => 'Bandung',
                'latitude' => -6.8951,
                'longitude' => 107.6047,
                'price_range' => '35000-90000',
                'opening_hours' => '08:00-23:00',
                'description' => 'Coworking modern dengan AC, loker, printer, parkir mobil, dan area ibadah.',
                'noise_level' => 'sedang',
                'facilities' => ['wifi', 'stop_kontak', 'ac', 'musholla', 'toilet', 'parkir', 'parkir_mobil', 'loker', 'printer'],
            ],
            [
                'place_name' => 'Kopi Braga Tenang',
                'category' => 'cafe',
                'address' => 'Jl. Braga No. 55, Bandung',
                'city' => 'Bandung',
                'latitude' => -6.9173,
                'longitude' => 107.6098,
                'price_range' => '18000-45000',
                'opening_hours' => '09:00-22:00',
                'description' => 'Kafe heritage dengan WiFi, AC, dan meja kecil untuk kerja singkat di pusat kota.',
                'noise_level' => 'sedang',
                'facilities' => ['wifi', 'ac', 'toilet', 'parkir_motor'],
            ],
            [
                'place_name' => 'Ruang Baca Taman Suropati',
                'category' => 'perpustakaan',
                'address' => 'Jl. Taman Suropati No. 3, Menteng',
                'city' => 'Jakarta',
                'latitude' => -6.1994,
                'longitude' => 106.8326,
                'price_range' => '0-0',
                'opening_hours' => '09:00-18:00',
                'description' => 'Ruang baca publik dekat taman dengan toilet, musholla, WiFi, dan parkir motor terbatas.',
                'noise_level' => 'tenang',
                'facilities' => ['wifi', 'musholla', 'toilet', 'parkir_motor'],
            ],
            [
                'place_name' => 'Dapur Kerja Tebet',
                'category' => 'restoran',
                'address' => 'Jl. Tebet Barat Dalam No. 22, Jakarta Selatan',
                'city' => 'Jakarta',
                'latitude' => -6.2322,
                'longitude' => 106.8495,
                'price_range' => '20000-60000',
                'opening_hours' => '10:00-23:00',
                'description' => 'Restoran nyaman untuk meeting informal dengan WiFi, stop kontak, AC, dan parkir mobil.',
                'noise_level' => 'sedang',
                'facilities' => ['wifi', 'stop_kontak', 'ac', 'toilet', 'parkir', 'parkir_mobil', 'tukang_parkir'],
            ],
            [
                'place_name' => 'Creative Corner Surabaya',
                'category' => 'lainnya',
                'address' => 'Jl. Raya Darmo No. 72, Surabaya',
                'city' => 'Surabaya',
                'latitude' => -7.2856,
                'longitude' => 112.7399,
                'price_range' => '15000-50000',
                'opening_hours' => '08:00-21:00',
                'description' => 'Ruang komunitas kreatif dengan WiFi, stop kontak, musholla, parkir motor, dan loker.',
                'noise_level' => 'ramai',
                'facilities' => ['wifi', 'stop_kontak', 'musholla', 'toilet', 'parkir_motor', 'loker'],
            ],
        ];

        foreach ($places as $data) {
            $facilityNames = $data['facilities'];
            unset($data['facilities']);

            $place = Place::updateOrCreate(
                ['place_name' => $data['place_name'], 'city' => $data['city']],
                array_merge($data, ['status' => 'active', 'data_completeness_score' => 80])
            );

            $facilityIds = Facility::whereIn('facility_name', $facilityNames)->pluck('facility_id');
            $place->facilities()->sync($facilityIds);

            foreach ($this->menuItemsFor($data['category']) as $index => $menuItem) {
                $photoUrls = $menuItem['photo_urls'] ?? [$menuItem['photo_url']];
                unset($menuItem['photo_urls']);

                $item = PlaceMenuItem::query()->updateOrCreate(
                    [
                        'place_id' => $place->place_id,
                        'menu_name' => $menuItem['menu_name'],
                    ],
                    array_merge($menuItem, [
                        'place_id' => $place->place_id,
                        'sort_order' => $index + 1,
                    ])
                );

                foreach (array_values(array_filter($photoUrls)) as $photoIndex => $photoUrl) {
                    PlaceMenuItemPhoto::query()->updateOrCreate(
                        [
                            'menu_item_id' => $item->menu_item_id,
                            'photo_url' => $photoUrl,
                        ],
                        [
                            'sort_order' => $photoIndex + 1,
                        ]
                    );
                }
            }

            foreach ($this->operatingHoursFor($data['category'], $data['opening_hours'] ?? null) as $hours) {
                $place->operatingHours()->updateOrCreate(
                    ['day_of_week' => $hours['day_of_week']],
                    $hours
                );
            }
        }
    }

    private function operatingHoursFor(string $category, ?string $defaultHours): array
    {
        [$defaultOpen, $defaultClose] = $this->splitHours($defaultHours);

        return collect(PlaceOperatingHour::DAY_LABELS)
            ->map(function (string $label, int $day) use ($category, $defaultOpen, $defaultClose) {
                $isWeekend = in_array($day, [6, 7], true);
                $isFriday = $day === 5;

                if ($category === 'perpustakaan' && $day === 7) {
                    return [
                        'day_of_week' => $day,
                        'opens_at' => null,
                        'closes_at' => null,
                        'is_closed' => true,
                    ];
                }

                $opensAt = $defaultOpen;
                $closesAt = $defaultClose;

                if ($isFriday && $category !== 'perpustakaan') {
                    $opensAt = $defaultOpen ?: '09:00';
                    $closesAt = '23:00';
                }

                if ($isWeekend) {
                    $opensAt = $category === 'perpustakaan' ? '09:00' : ($defaultOpen ?: '08:00');
                    $closesAt = match ($category) {
                        'coworking' => '20:00',
                        'perpustakaan' => '15:00',
                        'restoran' => '22:00',
                        default => '23:00',
                    };
                }

                return [
                    'day_of_week' => $day,
                    'opens_at' => $opensAt,
                    'closes_at' => $closesAt,
                    'is_closed' => false,
                ];
            })
            ->values()
            ->all();
    }

    private function splitHours(?string $hours): array
    {
        if (! $hours || ! str_contains($hours, '-')) {
            return ['08:00', '22:00'];
        }

        [$open, $close] = array_map('trim', explode('-', $hours, 2));

        return [$open ?: '08:00', $close ?: '22:00'];
    }

    private function menuItemsFor(string $category): array
    {
        return match ($category) {
            'coworking' => [
                ['menu_name' => 'Kopi Susu Fokus', 'category' => 'Minuman', 'price' => 18000, 'photo_url' => '/images/menu/kopi-susu.svg', 'photo_urls' => ['/images/menu/kopi-susu.svg', '/images/menu/americano.svg']],
                ['menu_name' => 'Tea Break Set', 'category' => 'Minuman', 'price' => 15000, 'photo_url' => '/images/menu/tea-break.svg', 'photo_urls' => ['/images/menu/tea-break.svg', '/images/menu/air-mineral.svg']],
                ['menu_name' => 'Snack Meeting', 'category' => 'Makanan', 'price' => 22000, 'photo_url' => '/images/menu/snack.svg', 'photo_urls' => ['/images/menu/snack.svg', '/images/menu/croissant.svg']],
            ],
            'perpustakaan' => [
                ['menu_name' => 'Air Mineral', 'category' => 'Minuman', 'price' => 5000, 'photo_url' => '/images/menu/air-mineral.svg', 'photo_urls' => ['/images/menu/air-mineral.svg']],
                ['menu_name' => 'Teh Hangat', 'category' => 'Minuman', 'price' => 7000, 'photo_url' => '/images/menu/tea-break.svg', 'photo_urls' => ['/images/menu/tea-break.svg', '/images/menu/air-mineral.svg']],
                ['menu_name' => 'Roti Isi', 'category' => 'Makanan', 'price' => 10000, 'photo_url' => '/images/menu/snack.svg', 'photo_urls' => ['/images/menu/snack.svg', '/images/menu/croissant.svg']],
            ],
            'restoran' => [
                ['menu_name' => 'Nasi Ayam Sambal Matah', 'category' => 'Makanan', 'price' => 25000, 'photo_url' => '/images/menu/nasi-ayam.svg', 'photo_urls' => ['/images/menu/nasi-ayam.svg', '/images/menu/mie-goreng.svg']],
                ['menu_name' => 'Mie Goreng Produktif', 'category' => 'Makanan', 'price' => 22000, 'photo_url' => '/images/menu/mie-goreng.svg', 'photo_urls' => ['/images/menu/mie-goreng.svg', '/images/menu/nasi-ayam.svg']],
                ['menu_name' => 'Es Teh Lemon', 'category' => 'Minuman', 'price' => 12000, 'photo_url' => '/images/menu/tea-break.svg', 'photo_urls' => ['/images/menu/tea-break.svg', '/images/menu/air-mineral.svg']],
            ],
            default => [
                ['menu_name' => 'Kopi Susu Gula Aren', 'category' => 'Minuman', 'price' => 18000, 'photo_url' => '/images/menu/kopi-susu.svg', 'photo_urls' => ['/images/menu/kopi-susu.svg', '/images/menu/americano.svg']],
                ['menu_name' => 'Americano', 'category' => 'Minuman', 'price' => 15000, 'photo_url' => '/images/menu/americano.svg', 'photo_urls' => ['/images/menu/americano.svg', '/images/menu/kopi-susu.svg']],
                ['menu_name' => 'Croissant Butter', 'category' => 'Makanan', 'price' => 20000, 'photo_url' => '/images/menu/snack.svg', 'photo_urls' => ['/images/menu/snack.svg', '/images/menu/croissant.svg']],
            ],
        };
    }
}
