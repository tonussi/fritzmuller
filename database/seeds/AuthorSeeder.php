<?php
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use App\Article;
use App\Author;
use App\ArticleAuthor;

class AuthorSeeder extends Seeder
{
    private $faker;

    public function run()
    {
        $this->faker = FactoryFaker::create();
        $this->createAuthors();
        $this->addRandomAuthors();
    }

    private function createAuthors()
    {
        for ($i = 0; $i < 19; $i ++)
            $this->createAuthor();
    }

    private function addRandomAuthors()
    {
        $arr_a = Article::all()->pluck('id')->toArray();
        $arr_b = Author::all()->pluck('id')->toArray();
        for ($i = 0; $i < count($arr_a); $i++) {
            $a_id = $this->faker->randomElement($arr_a);
            $b_id = $this->faker->randomElement($arr_b);
            ArticleAuthor::create([
                'article_id' => $a_id,
                'author_id' => $b_id,
            ]);
        }
    }

    private function createAuthor()
    {
        Author::create([
            'author_name' => $this->faker->sentence(6, true),
            'author_surname' => $this->faker->sentence(6, true),
            'bio' => $this->faker->sentence(6, true),
            'contact' => $this->faker->sentence(6, true),
            'figure_path' => '/photos/1/Cristina/avatar.jpg'
        ]);
    }
}
