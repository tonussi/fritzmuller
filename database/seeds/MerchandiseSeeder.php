<?php
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use App\Merchandise;

class MerchandiseSeeder extends Seeder
{
    private $faker;

    public function run()
    {
        $this->faker = FactoryFaker::create();
        $this->createMerchandise();
    }

    private function createMerchandise()
    {
        for ($i = 0; $i < 5; $i ++)
            $this->createRunningActivity();
    }

    private function createRunningActivity()
    {
        return Merchandise::create([
            'figure_path' => '/photos/1/Cristina/ra.png',
            'title' => $this->faker->word,
            'activity_description' => $this->faker->text(140),
            'target_url' => '/guest/articles/read/1',
            'active' => true
        ]);
    }
}
