<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker = \Faker\Factory::create('fa_IR');
        
        $persianTitles = [
            'آموزش جامع لاراول برای مبتدیان',
            'معرفی فریم‌ورک Vue.js و مزایای آن',
            'مقایسه React و Angular در سال ۲۰۲۴',
            'برنامه‌نویسی موبایل با فلاتر',
            'پایتون و هوش مصنوعی: چگونه شروع کنیم؟',
            'دیزاین پترن‌های کاربردی در برنامه‌نویسی',
            'آشنایی با Git و GitHub برای مدیریت پروژه',
            'امنیت وب و روش‌های جلوگیری از هک',
            'فریم‌ورک‌های CSS محبوب در طراحی وب',
            'آموزش API نویسی با Laravel',
            'توسعه وب با استفاده از PHP 8',
            'معرفی Docker و کاربردهای آن',
            'روش‌های بهینه‌سازی سایت برای موتورهای جستجو',
            'برنامه‌نویسی فانکشنال در جاوااسکریپت',
            'مدیریت دیتابیس با MongoDB',
            'معرفی Node.js و مزایای آن در توسعه وب',
        ];
        
        $title = $this->faker->randomElement($persianTitles) . ' ' . $this->faker->words(2, true);
        $slug = Str::slug($title);
        
        $persianContent = <<<EOT
<p>به نام خدا</p>

<h2>مقدمه</h2>
<p>{$this->faker->paragraph(3)}</p>

<h2>بخش اول</h2>
<p>{$this->faker->paragraph(4)}</p>
<p>{$this->faker->paragraph(3)}</p>

<h2>بخش دوم</h2>
<p>{$this->faker->paragraph(5)}</p>
<ul>
    <li>{$this->faker->sentence()}</li>
    <li>{$this->faker->sentence()}</li>
    <li>{$this->faker->sentence()}</li>
    <li>{$this->faker->sentence()}</li>
</ul>

<h2>بخش سوم</h2>
<p>{$this->faker->paragraph(4)}</p>
<p>{$this->faker->paragraph(3)}</p>

<h2>جمع‌بندی</h2>
<p>{$this->faker->paragraph(3)}</p>
<p>امیدوارم این مطلب برای شما مفید بوده باشد. لطفا نظرات خود را با ما به اشتراک بگذارید.</p>
EOT;

        return [
            'title' => $title,
            'slug' => $slug,
            'summary' => $this->faker->paragraph(2),
            'content' => $persianContent,
            'image' => 'https://picsum.photos/seed/' . $slug . '/800/600',
            'category_id' => \App\Models\Category::factory(),
            'published' => true,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
