<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Search\SearchHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SearchHistoryFactory extends Factory
{
    protected $model = SearchHistory::class;

    public function definition(): array
    {
        return [
            'term' => $this->faker->word(),
            'number_of_searches' => 0,
        ];
    }
}
