<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $this->faker = \Faker\Factory::create('fa_IR');
        
        $persianCategories = [
            'برنامه‌نویسی وب',
            'توسعه موبایل',
            'هوش مصنوعی',
            'DevOps',
            'امنیت سایبری',
            'مهندسی داده',
        ];
        
        $name = $this->faker->unique()->randomElement($persianCategories);
        
        return [
            'name' => $name,
            'description' => $this->faker->sentence(rand(10, 15)),
            'slug' => Str::slug($name),
        ];
    }
}
