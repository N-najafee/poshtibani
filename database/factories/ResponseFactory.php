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
            'description'=>$this->faker->text(rand(10,100)),
            'user_id'=>$this->faker->numberBetween(1,1),
            'ticket_id'=>$this->faker->numberBetween(1,5),
        ];
    }
}
