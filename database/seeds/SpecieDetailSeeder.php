<?php
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use App\SpecieDetail;
use App\TaxonomyGroup;

class SpecieDetailSeeder extends Seeder
{
    private $faker;

    public function run()
    {
        $this->faker = FactoryFaker::create();
        $this->createSpecieDetails();
        $this->specieDetails();
    }

    private function createSpecieDetails()
    {
        $arr_a = TaxonomyGroup::all()->pluck('id')->toArray();
        for ($i = 0; $i < count($arr_a); $i++)
        {
            $a_id = $this->faker->randomElement($arr_a);
            SpecieDetail::create([
                'taxonomy_group_id' => $a_id,
                'specie_description' => $this->faker->sentence(6, true),
                'figure_path' => 'https://placeimg.com/400/400/animals'
            ]);
        }
    }

    private function specieDetails()
    {
        $arr_b = SpecieDetail::all()->pluck('id')->toArray();
        for ($i = 0; $i < count($arr_b); $i++) {
            $b_id = $this->faker->randomElement($arr_b);
        }
    }
}
