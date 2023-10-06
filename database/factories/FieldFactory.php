<?php

namespace Database\Factories;

use App\Models\Field;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Field>
 */
class FieldFactory extends Factory
{
    protected $model = Field::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        $array = ['string','number','date'];
        $langs = ['us','ca','gb'];

        do {
            $uniqueCode = Str::random(8);
        } while (\App\Models\Field::where('code', $uniqueCode)->exists());

        do {
            $tagName = 'standard_' . Str::random(4);
        }  while (\App\Models\Field::where('tag', $tagName)->exists());

        return [
            'name' => $faker->word(),
            'type' => 'standard',
            'class' => $array[array_rand($array)],
            'tag' => $tagName,
            'code' => $uniqueCode,
            'language' => $langs[array_rand($langs)],
        ];
    }
}
