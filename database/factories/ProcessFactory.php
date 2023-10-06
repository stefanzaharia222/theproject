<?php

namespace Database\Factories;

use App\Models\Process;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Field>
 */
class ProcessFactory extends Factory
{
    protected $model = Process::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();

        do {
            $uniqueCode = \Illuminate\Support\Str::random(8);
        } while (\App\Models\Process::where('code', $uniqueCode)->exists());

        $name = $faker->word;

        do {
            $tagName = 'standard_'.Str::random(4);
        } while (\App\Models\Process::where('tag', $tagName)->exists());

        return [
            'name' => $name,
            'code' => $uniqueCode,
            'tag' => $tagName,
        ];
    }
}
