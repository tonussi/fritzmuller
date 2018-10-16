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
        for ($i = 0; $i < 19; $i ++)
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
            'figure_path' => '/photos/1/Cristina/catav.jpg'
        ]);
    }
}
