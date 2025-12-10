<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraph(3),
            'emp_id' => Employee::inRandomOrder()->first()->id ?? Employee::factory(),
            'date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'status' => $this->faker->randomElement([0, 1]),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
