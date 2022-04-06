<?php

namespace Database\Seeders;

use App\Models\Admin\Post;
use Faker\Factory as Faker;
use App\Models\Admin\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        $faker = Faker::create();
        while ($i <= 20) {
            $category = Category::find(rand(1, 6));
            $post = Post::create([
                'code' => time() . $faker->unique()->numberBetween(100000, 999999),
                'name' => $faker->sentence,
                'slug' => $faker->slug,
                'category_id' => $category->id,
                'main_category_id' => $category->main_category_id ?? $category->id,
                'author_id' => 1,
                'excerpt' => $faker->sentence,
                'body' => $faker->paragraph,
                'image' => 'static/images/properties/1/pro' . rand(1, 5) . '.jpg',
                'status' => 3,
                'featured' => rand(0, 1),
                'priority' => rand(1, 100),
                'video' => 'https://www.youtube.com/watch?v=127ng7botO4&ab_channel=OfferZenOrigins',
                'meta_title' => $faker->sentence,
                'meta_description' => $faker->sentence,
                'meta_keywords' => $faker->words(3, false),
            ]);
            $post->categories()->attach([1, 2, 3, 4, 5, 6]);
            $i++;
        }
    }
}
