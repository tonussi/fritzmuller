<?php
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use App\SpeciesDetail;
use App\TaxonomyGroup;
use App\TaxonomyRankClass;
use App\TaxonomyRankFamily;
use App\TaxonomyRankGenus;
use App\TaxonomyRankKingdom;
use App\TaxonomyRankOrder;
use App\TaxonomyRankPhylum;
use App\TaxonomyRankSpecie;
use App\PopularName;

class TaxasSeeder extends Seeder
{
    private $faker;

    public function run()
    {
        $this->faker = FactoryFaker::create();
        $this->createTaxaGroups();
    }

    private function createTaxaGroups()
    {
        for ($i = 0; $i < 29; $i ++)
            $this->createTaxonomyRank();
    }

    private function createTaxonomyRank()
    {
        $obj_class = TaxonomyRankClass::create(['rank_name' => $this->faker->sentence(1, true)]);
        $obj_family = TaxonomyRankFamily::create(['rank_name' => $this->faker->sentence(1, true)]);
        $obj_genus = TaxonomyRankGenus::create(['rank_name' => $this->faker->sentence(1, true)]);
        $obj_kingdom = TaxonomyRankKingdom::create(['rank_name' => $this->faker->sentence(1, true)]);
        $obj_order = TaxonomyRankOrder::create(['rank_name' => $this->faker->sentence(1, true)]);
        $obj_phylum = TaxonomyRankPhylum::create(['rank_name' => $this->faker->sentence(1, true)]);
        $obj_species = TaxonomyRankSpecie::create(['rank_name' => $this->faker->sentence(1, true)]);
        $tax_group = TaxonomyGroup::create([
            'class_id' => $obj_class->id,
            'family_id' => $obj_family->id,
            'genus_id' => $obj_genus->id,
            'kingdom_id' => $obj_kingdom->id,
            'order_id' => $obj_order->id,
            'phylum_id' => $obj_phylum->id,
            'specie_id' => $obj_species->id
        ]);
    }
}
