<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topic>
 */
class TopicFactory extends Factory
{
    protected $model = Topic::class;

    public function definition(): array
    {
        $sentence = fake()->sentence();
        $updatedTime = fake()->dateTimeThisMonth();
        $createdAt = fake()->dateTimeThisMonth($updatedTime);

        return [
            'title' => $sentence,
            'body' => fake()->text(),
            'excerpt' => $sentence,
            'background' => asset('uploads/images/test/image_2.jpg'),
            'created_at' => $createdAt,
            'updated_at' => $updatedTime,
        ];
    }
}
