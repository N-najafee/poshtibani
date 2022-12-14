<?php

namespace Database\Factories;

use App\Http\Consts\Userconsts;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' =>$this->faker->randomElement(['admin','response','user']),
            'email' => $this->faker->unique()->safeEmail(),
            'role'=>Userconsts::USER,
            'email_verified_at' => now(),
            'password' => '$2y$10$iDxsauYaUssC5uGfuilGXu7C4BBM03OjBgiBHvix0VVgVWVzzwi1K', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
