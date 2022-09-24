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
            'description'=>$this->faker->text(rand(30,60)),
            'user_id'=>$this->faker->numberBetween(1,3),
            'ticket_id'=>$this->faker->numberBetween(3,6),
        ];
    }
}
