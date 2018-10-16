<?php
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use App\SpeciesDetail;
use App\TaxonomyGroup;
use App\PopularName;

class SpeciesDetailSeeder extends Seeder
{
    private $faker;

    public function run()
    {
        $this->faker = FactoryFaker::create();
        $this->createSpeciesDetails();
        $this->speciesDetails();
    }

    private function createSpeciesDetails()
    {
        $arr_a = TaxonomyGroup::all()->pluck('id')->toArray();
        for ($i = 0; $i < count($arr_a); $i++)
        {
            $a_id = $this->faker->randomElement($arr_a);
            SpeciesDetail::create([
                'taxonomy_group_id' => $a_id,
                'species_description' => $this->faker->sentence(6, true),
                'figure_path' => '/photos/1/Cristina/coruja.png'
            ]);
        }
    }

    private function speciesDetails()
    {
        $arr_b = SpeciesDetail::all()->pluck('id')->toArray();
        for ($i = 0; $i < count($arr_b); $i++) {
            $b_id = $this->faker->randomElement($arr_b);
            PopularName::create([
                'popular_name' => $this->faker->sentence(1, true),
                'species_detail_id' => $b_id
            ]);
        }
    }
}
