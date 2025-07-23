<?php

namespace Database\Factories;

use App\Models\Tasck;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TasckFactory extends Factory
{
    protected $model = Tasck::class;

    public function definition()
    {
        $names = [
            'المهمة الاولي',
            'المهمة الثانية',
            'المهمة الثالثة',
            'المهمة الرابعة',
        ];

        return [
            'name' => $this->faker->randomElement($names),
        ];
    }
}
