<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MCourseCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'fk_department_id' => 53,
            'category_name_hi' => fake()->sentence('5'),
            'category_name_en' => fake()->sentence('5'),
            'status' => 1,
            'created_by' => 1,
            'created_at' => now(),
        ];
    }
}
