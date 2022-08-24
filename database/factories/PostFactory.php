<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class postFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tittle = 'Bài Viết Số ' . $this->faker->numberBetween(1, 100000);
        $slug = Str::slug($tittle);
        $arrTag = [
            'lập trình', 'tool', 'php', 'laravel', 'nodejs', 'java', 'review', 'python','linh tinh'
        ];
        
        return [
            'author_id' => $this->faker->randomElement(User::query()->pluck('id')),
            'category_id' => $this->faker->randomElement(Category::query()->pluck('id')),
            'tittle' => $tittle,
            'content' => 'Nội Dung '. $tittle .' Nè ',
            'slug' => $slug,
            'tags' => implode(",",$this->faker->randomElements($arrTag, 3, false)),
            'thumbnail' => 'thumbnail.jpg',
        ];
    }
}
