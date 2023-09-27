<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketType>
 */
class TicketTypeFactory extends Factory
{
    protected $model = TicketType::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'ticket_type_name' => $this->faker->name,
            'available_quantity' => $this->faker->numberBetween(1, 100),
            'sold_quantity' => $this->faker->numberBetween(1, 100),
            'value' => $this->faker->randomFloat(8 , 2),
            'description' => $this->faker->sentence,
            'sale_start_date' => $this->faker->date,
            'sale_end_date' => $this->faker->date,
            'purchase_limit' => $this->faker->numberBetween(1, 100),
            'event_id' => Event::factory()
        ];
    }
}
