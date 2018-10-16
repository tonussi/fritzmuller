<?php
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use App\Article;
use App\Tag;
use App\ArticleTag;

class TagSeeder extends Seeder
{
    private $faker;

    public function run()
    {
        $this->faker = FactoryFaker::create();
        $this->createTags();
        $this->addRandomTags();
    }

    private function createTags()
    {
        for ($i = 0; $i < 29; $i ++)
            $this->createTag();
    }

    private function addRandomTags()
    {
        $arr_a = Article::all()->pluck('id')->toArray();
        $arr_b = Tag::all()->pluck('id')->toArray();
        for ($i = 0; $i < count($arr_a); $i++) {
            $a_id = $this->faker->randomElement($arr_a);
            $b_id = $this->faker->randomElement($arr_b);
            ArticleTag::create([
                'article_id' => $a_id,
                'tag_id' => $b_id,
            ]);
        }
    }

    private function createTag()
    {
        Tag::create([
            'word' => $this->faker->words(3, true)
        ]);
    }
}
