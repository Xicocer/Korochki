<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'login' => 'Admin',
            'full_name' => 'Администратор Системы',
            'phone' => '8(000)000-00-00',
            'email' => 'admin@koroki.net',
            'password' => \Hash::make('KorokNET'),
            'role' => 'admin',
        ]);

        $courses = [
            ['title' => 'Основы алгоритмизации и программирования', 'description' => 'Базовый курс по логике и коду.'],
            ['title' => 'Основы веб-дизайна', 'description' => 'Проектирование интерфейсов под мобилки.'],
            ['title' => 'Основы проектирования баз данных', 'description' => 'Всё про SQL и архитектуру данных.'],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}
