<?php

namespace Database\Seeders;

use App\Models\Topic;
use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
{
    public function run(): void
    {
        $userIds = User::query()->pluck('id')->all();
        if (empty($userIds)) {
            return;
        }

        $faker = app(Generator::class);

        $topics = Topic::factory()
            ->count(15)
            ->make()
            ->each(function (Topic $topic) use ($userIds, $faker): void {
                $topic->user_id = $faker->randomElement($userIds);
            });

        Topic::insert($topics->toArray());
    }
}
