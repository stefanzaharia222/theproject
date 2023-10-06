<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Field>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $uniqueCode = \Illuminate\Support\Str::random(8);
        } while (\App\Models\Ticket::where('code', $uniqueCode)->exists());

        $faker = \Faker\Factory::create();

            $name = $faker->word;

        do {
            $tagName = 'standard_' . Str::random(4);
        }  while (\App\Models\Field::where('tag', $tagName)->exists());

        return [
            'name' => $name,
            'code' => $uniqueCode,
            'tag' => $tagName,
        ];
    }
}
