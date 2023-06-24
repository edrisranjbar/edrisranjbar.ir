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
                'route' => 'home',
                'ordering' => 1,
            ],
            [
                'name' => 'وبلاگ',
                'route' => 'products.index',
                'ordering' => 2,
            ],
            [
                'name' => 'پادکست',
                'route' => 'about.us',
                'ordering' => 3,
            ],
            [
                'name' => 'دوره ها',
                'route' => 'about.us',
                'ordering' => 3,
            ],
        ];

        foreach ($links as $key => $navbar) {
            Navbar::create($navbar);
        }
    }
}
