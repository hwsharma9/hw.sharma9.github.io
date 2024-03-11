<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CourseTopic>
 */
class CourseTopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(3),
            'summary' => '
                <h1><samp>Introduction</samp></h1>
                <p>
                    <span style="font-family:georgia,serif;"><span style="font-size:14px;">Faker provides adapters for Object-Relational and Object-Document Mappers (currently, Propel, Doctrine2, CakePHP, Spot2, Mandango and Eloquent are supported). These adapters ease the population of databases through the Entity classes provided by an ORM library (or the population of document stores using Document classes provided by an ODM library).</span></span><br />
                    &nbsp;</p>
                <ul>
                    <li>
                        title 1</li>
                    <li>
                        title 2</li>
                    <li>
                        title 3</li>
                </ul>
            ',
            'status' => 1,
            'is_edited' => 0,
            'course_status' => rand(0, 4)
        ];
    }
}
