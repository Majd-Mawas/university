<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $subjects = [
            ["name" => "Reading and Writing"],
            ["name" => "Math"],
            ["name" => "Information and Ideas"],
            ["name" => "Craft and Structure"],
            ["name" => "Expression of Ideas"],
            ["name" => "Standard English Conversations"],
            ["name" => "Algebra"],
            ["name" => "Advanced Math"],
            ["name" => "Problem Solving and Data Analysis"],
            ["name" => "Geometry and Trigonometry"],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
