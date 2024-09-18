<?php

namespace Homeful\References\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Homeful\Common\Classes\Input as InputFieldName;
use Homeful\References\Models\Input;

class InputFactory extends Factory
{
    protected $model = Input::class;

    public function definition()
    {
        return [
            InputFieldName::SKU => $this->faker->word(),
            InputFieldName::WAGES => $this->faker->numberBetween(10000, 120000) * 1.00,
            InputFieldName::TCP => $this->faker->numberBetween(850000, 4000000) * 1.00,
            InputFieldName::PERCENT_DP => $this->faker->numberBetween(5, 10) / 100,
            InputFieldName::PERCENT_MF => $this->faker->numberBetween(8, 10) / 100,
            InputFieldName::DP_TERM => $this->faker->numberBetween(12, 24) * 1.00,
            InputFieldName::BP_TERM => $this->faker->numberBetween(20, 30) * 1.00,
            InputFieldName::BP_INTEREST_RATE => $this->faker->numberBetween(3, 7) / 100,
            InputFieldName::SELLER_COMMISSION_CODE => $this->faker->word(),
//            InputFieldName::PROMO_CODE => $this->faker->word(),
        ];
    }
}
