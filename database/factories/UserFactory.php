<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
       return [
    'nom' => $this->faker->name(),
    'email' => $this->faker->unique()->safeEmail(),
    'password' => bcrypt('password123'),
    'role' => 'participant',
    'est_actif' => true,   // utilise la bonne colonne
    'pronoms' => $this->faker->firstName(),
    'adresse' => $this->faker->address(),
];

    }
}
