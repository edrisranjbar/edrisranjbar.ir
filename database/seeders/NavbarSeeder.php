<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Navbar;

class NavbarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = [
            [
                'name' => 'صفحه نخست',
                'route' => '/',
                'ordering' => 1,
            ],
            [
                'name' => 'وبلاگ',
                'route' => '/blog',
                'ordering' => 2,
            ],
            [
                'name' => 'پادکست',
                'route' => '/podcasts',
                'ordering' => 3,
            ],
            [
                'name' => 'دوره ها',
                'route' => '/tutorials',
                'ordering' => 4,
            ],
            [
                'name' => 'حمایت مالی',
                'route' => '/donate',
                'ordering' => 5,
            ],
        ];

        foreach ($links as $key => $navbar) {
            Navbar::create($navbar);
        }
    }
}
