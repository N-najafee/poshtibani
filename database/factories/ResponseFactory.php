<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ResponseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description'=>$this->faker->text(rand(60,100)),
            'user_id'=>$this->faker->numberBetween(4,6),
            'ticket_id'=>$this->faker->numberBetween(3,6),
        ];
    }
}
