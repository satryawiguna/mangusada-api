<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $profileable = $this->profileable();

        return [
            'profileable_id' => $profileable::factory(),
            'profileable_type' => $profileable,
            'name' => $this->faker->firstName() . " " . $this->faker->lastName(),
            'address' => $this->faker->address(),
            'phone_number' => $this->faker->phoneNumber(),
            'sim_number' => $this->faker->randomNumber(9),
            'created_by' => 'system'
        ];
    }

    public function profileable()
    {
        return $this->faker->randomElement([
            User::class
        ]);
    }
}
