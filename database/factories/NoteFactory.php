<?php
namespace Database\Factories;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Note>
 */
class NoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'     => $this->faker->sentence(),
            'content'   => $this->faker->paragraphs(3, true),
            'user_id'   => User::factory(),
            'is_pinned' => false,
        ];
    }
}