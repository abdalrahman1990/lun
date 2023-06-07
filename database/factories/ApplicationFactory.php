<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'        =>  $this->faker->name('male'|'female'),
            'email'       =>  $this->faker->email,
            'country'     =>  $this->faker->country,
            'phone'       =>  $this->faker->e164PhoneNumber,

            'idea' =>  $this->faker->sentence(2),
            'des_idea' =>  $this->faker->sentence(10),
            'status'      =>  $this->faker->randomElement($array = array ('Pending','Accepted','Rejected')),
            'created_at'     => now(),
            'updated_at'        => now(),
        ];
    }
}
