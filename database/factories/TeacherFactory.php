<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Teacher>
 */
class TeacherFactory extends Factory
{
    protected $model = Teacher::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nip' => $this->faker->unique()->numerify('19##########'),
            'name' => $this->faker->name(),
            'birth_date' => $this->faker->date(),
            'address' => $this->faker->address(),
            'gender' => $this->faker->randomElement(['L', 'P']),
            'is_homeroom' => $this->faker->boolean(30)
        ];
    }
}
