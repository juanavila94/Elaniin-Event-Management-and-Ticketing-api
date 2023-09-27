<?php

namespace Database\Factories;

use App\Models\Attendee;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusOption = ['active', 'completed', 'underReview', 'refunded'] ;

        return [
            
            'date_of_purchase' => $this->faker->date,
            'status'=> $this->faker->randomElement($statusOption),
            'total_amount' => $this->faker->numberBetween(1, 100),
            'attendee_id' => Attendee::factory()
        ];
    }
}
