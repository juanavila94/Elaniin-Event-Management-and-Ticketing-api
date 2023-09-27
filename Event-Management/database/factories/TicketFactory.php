<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusOption = [ 'checkedIn', 'checkedOut', 'refunded', 'notRefunded'];

        return [
            
            'quantity'=> $this->faker->numberBetween(1, 100),
            'attendee_name' => $this->faker->name,
            'status' => $this->faker->randomElement($statusOption),
            'ticket_type_id' => TicketType::factory(),
            'order_id' => Order::factory(),

        ];
    }
}
