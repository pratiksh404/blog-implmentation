<?php

namespace Database\Seeders;

use App\Models\Admin\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            // Category A Category
            [
                'id' => 1,
                'code' => rand(100000, 999999),
                'name' => 'Category A',
                'slug' => 'category-a',
                'parent_id' => null,
                'active' => 1,
                'color' => random_color(),
                'icon' => 'fa fa-home',
                'position' => 1,
                'meta_name' => 'Category A',
                'meta_keywords' => array('blog', 'category-a'),
            ],
            [
                'id' => 2,
                'code' => rand(100000, 999999),
                'name' => 'Sub 1',
                'slug' => 'category-a-sub-1',
                'parent_id' => 1,
                'main_category_id' => 1,
                'active' => 1,
                'color' => random_color(),
                'icon' => 'fa fa-home',
                'position' => 1,
                'meta_name' => 'Sub 1',
                'meta_keywords' => array('blog', 'category-a', 'sub-1'),
            ],
            [
                'id' => 3,
                'code' => rand(100000, 999999),
                'name' => 'Sub 2',
                'slug' => 'category-a-sub-2',
                'parent_id' => 1,
                'main_category_id' => 1,
                'active' => 1,
                'color' => random_color(),
                'icon' => 'fa fa-home',
                'position' => 2,
                'meta_name' => 'Sub 2',
                'meta_keywords' => array('blog', 'category-a', 'sub-2'),
            ],
            [
                'id' => 4,
                'code' => rand(100000, 999999),
                'name' => 'Category B',
                'slug' => 'category-b',
                'parent_id' => null,
                'active' => 1,
                'color' => random_color(),
                'icon' => 'fa fa-home',
                'position' => 2,
                'meta_name' => 'Category B',
                'meta_keywords' => array('blog', 'category-b'),
            ],
            [
                'id' => 5,
                'code' => rand(100000, 999999),
                'name' => 'Sub 1',
                'slug' => 'category-b-sub-1',
                'parent_id' => 4,
                'main_category_id' => 1,
                'active' => 1,
                'color' => random_color(),
                'icon' => 'fa fa-home',
                'position' => 1,
                'meta_name' => 'Sub 1',
                'meta_keywords' => array('blog', 'category-b', 'sub-1'),
            ],
            [
                'id' => 6,
                'code' => rand(100000, 999999),
                'name' => 'Sub 2',
                'slug' => 'category-b-sub-2',
                'parent_id' => 4,
                'main_category_id' => 1,
                'active' => 1,
                'color' => random_color(),
                'icon' => 'fa fa-home',
                'position' => 2,
                'meta_name' => 'Sub 2',
                'meta_keywords' => array('blog', 'category-b', 'sub-2'),
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
