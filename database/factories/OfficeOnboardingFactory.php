<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OfficeOnboarding>
 */
class OfficeOnboardingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fk_department_id' => 53,
            'fk_office_id' => 55,
            'nodal_name' => fake()->name(),
            'nodal_contact_number' => fake()->phoneNumber(),
            'nodal_email' => fake()->email(),
            'office_address' => fake()->address(),
        ];
    }
}
