<?php
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use App\Article;

class ArticleSeeder extends Seeder
{

    private $faker;

    public function run()
    {
        $this->faker = FactoryFaker::create();
        $this->createArticles();
    }

    private function createArticles()
    {
        for ($i = 0; $i < 5; $i ++)
            $this->createArticle();
    }

    private function createArticle()
    {
        Article::create([
            'title' => $this->faker->word,
            'subtitle' => $this->faker->sentence(6, true),
            'article_content' => $this->faker->text(200),
            'publication_date' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'active' => $this->faker->boolean(30),
            'figure_path' => 'https://placeimg.com/940/480/nature',
            'rating' => $this->faker->randomNumber(100) % 6,
            'price' => $this->faker->randomFloat(2)
        ]);
    }
}
