<?php
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use App\Article;
use App\SpecieDetail;
use App\ArticleSpecie;

class ArticleSpecieSeeder extends Seeder
{
    private $faker;

    public function run()
    {
        $this->faker = FactoryFaker::create();
        $this->addRandomAnimalToArticles();
    }

    private function addRandomAnimalToArticles()
    {
        $arr_a = Article::all()->pluck('id')->toArray();
        $arr_b = SpecieDetail::all()->pluck('id')->toArray();
        for ($i = 0; $i < count($arr_a); $i++) {
            $a_id = $this->faker->randomElement($arr_a);
            $b_id = $this->faker->randomElement($arr_b);
            ArticleSpecie::create([
                'article_id' => $a_id,
                'species_id' => $b_id,
            ]);
        }
    }
}
