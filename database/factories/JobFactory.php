<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'        => $this->faker->randomElement($array = array ('Backend Developer','Frontend developer','HR','FullStack Developer')),
            'type'         =>  $this->faker->sentence(1),
            'address'      =>  $this->faker->address(),
            'hierarchical' =>  $this->faker->sentence(1),
            'salary'       => $this->faker->numberBetween($min = 1000, $max = 9000),
            'experience'   =>  $this->faker->text(200),
            'description'  =>  $this->faker->text(200),
            'requirement'  =>  $this->faker->text(200),
            'status'       =>  $this->faker->randomElement($array = array ('Opened','Closed','Pending')),
            'start_time'   =>  now(),
            'end_time'     =>  now()->addhours(8),
            'image'        =>  'https://via.placeholder.com/200x250',
            'created_at'   => now(),
            'updated_at'   => now(),
        ];
    }
}
