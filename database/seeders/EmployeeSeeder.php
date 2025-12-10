<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testEmployees = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@company.com',
                'password' => Hash::make('password123'),
                'phone' => '+1-555-0101',
                'dob' => '1985-03-15',
                'city' => 'New York',
                'image' => 'employee/default-avatar.jpg',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@company.com',
                'password' => Hash::make('password123'),
                'phone' => '+1-555-0102',
                'dob' => '1990-07-22',
                'city' => 'Los Angeles',
                'image' => 'employee/default-avatar.jpg',
            ],
            [
                'name' => 'Test Employee',
                'email' => 'b@gmail.com',
                'password' => Hash::make('password'),
                'phone' => '+1-555-0103',
                'dob' => '1988-12-05',
                'city' => 'Chicago',
                'image' => 'employee/default-avatar.jpg',
            ],
        ];

        foreach ($testEmployees as $employee) {
            Employee::create($employee);
        }

        Employee::factory(20)->create();
    }
}
