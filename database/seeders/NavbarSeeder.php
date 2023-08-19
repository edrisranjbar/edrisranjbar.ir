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
                'route' => '/podcast',
                'ordering' => 3,
            ],
            [
                'name' => 'دوره ها',
                'route' => '/ttuorials',
                'ordering' => 3,
            ],
        ];

        foreach ($links as $key => $navbar) {
            Navbar::create($navbar);
        }
    }
}
