<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 3 predefined categories
        $categories = [
            [
                'name' => 'برنامه‌نویسی وب',
                'description' => 'مطالب مرتبط با طراحی و توسعه وب',
                'slug' => 'web-development',
            ],
            [
                'name' => 'برنامه‌نویسی موبایل',
                'description' => 'توسعه اپلیکیشن‌های موبایل برای اندروید و iOS',
                'slug' => 'mobile-development',
            ],
            [
                'name' => 'هوش مصنوعی',
                'description' => 'مطالب مرتبط با یادگیری ماشین، شبکه‌های عصبی و هوش مصنوعی',
                'slug' => 'artificial-intelligence',
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
