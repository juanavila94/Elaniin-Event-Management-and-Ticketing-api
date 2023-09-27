<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusOptions = ['Drafted', 'Published'];
        return [
            'event_name' => $this->faker->name,
            'description' => $this->faker->text,
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'location' => $this->faker->address,
            'header_image' =>$this->faker->imageUrl,
            'status' => $this->faker->randomElement($statusOptions),
            'user_id' => User::factory()
        ];
    }
}
