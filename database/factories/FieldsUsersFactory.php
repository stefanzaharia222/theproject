<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FieldUser>
 */
class FieldsUsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return mixed
     */
    public function definition(): mixed
    {
        // get all fields
        $fields = Field::all()->pluck('id')->toArray();
        $users = User::all()->pluck('id')->toArray();

        if (count($users) > 0) {
            return [
                'field_id' => $fields[array_rand($fields)],
                'user_id' => $users[array_rand($users)],
            ];
        }
    }
}
