<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'amount' => $this->faker->numberBetween(100000, 1000000),
            'payment_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status' => 'Lunas',
        ];
    }
}