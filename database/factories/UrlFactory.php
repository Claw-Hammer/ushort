<?php

namespace Database\Factories;

use App\Models\Url;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UrlFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Url::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'real_url' => $this->faker->url(),
            'short_url' => env('APP_URL') . "/" . $this->faker->unique()->regexify('[a-zA-Z0-9]{3}'),
            'number_of_visits' => $this->faker->numberBetween(0, 500),
            'nsfw' => $this->faker->numberBetween(0, 1),
        ];
    }
}
