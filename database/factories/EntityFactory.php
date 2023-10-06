<?php

namespace Database\Factories;

use App\Models\Entity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EntityFactory extends Factory
{
    protected $model = Entity::class;

    public function definition(): array
    {
        do {
            $uniqueCode = \Illuminate\Support\Str::random(8);
        } while (\App\Models\Entity::where('code', $uniqueCode)->exists());

        return [
            'name' => $this->faker->company(),
            'code' => $uniqueCode,
            'created_at' => Carbon::now(), 'updated_at' => Carbon::now()
        ];
    }
}
