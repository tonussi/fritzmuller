<?php
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use App\SpecieDetail;
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
    private $animalia_species = [
        'Doberman Pinscher',
        'Dwarf Crocodile',
        'Brazilian Terrier',
        'Howler Monkey',
        'Leopard Seal',
        'Minke Whale',
        'Tawny Owl',
        'Tasmanian Devil',
        'Red-handed Tamarin',
        'Spectacled Bear',
        'Sumatran Rhinoceros',
        'White Tiger',
        'Zebra Shark',
        'Yellow-Eyed Penguin',
        'American Eskimo Dog',
        'African Forest Elephant',
        'Chinstrap Penguin',
        'Asian Giant Hornet',
        'Fire-Bellied Toad',
        'Grasshopper',
        'Estrela Mountain Dog',
        'Leopard Tortoise',
        'Magpie',
        'Marsh Frog',
        'Pink Fairy Armadillo'
    ];

    private $plantae_species = [
        'Brownea macrophylla',
        'Callicarpa nudiflora',
        'Adansonia digitata',
        'Talisia esculenta',
        'Nephelium lappaceum',
        'Litchi chinensis',
        'Magnolia grandiflora',
        'Mammea americana',
        'Chambeyronia macrocarpa',
        'Artocarpus heterophyllus',
        'Caryota mitis',
        'Euterpe oleracea',
        'Clerodendrum quadriloculare',
        'Hancornia speciosa',
        'Eugenia stipitata',
        'Anacardium occidentale',
        'Liriodendron tulipifera',
        'Buckinghamia celsissima',
        'Viburnum opulus',
        'Trachycarpus fortunei',
        'Dipteryx alata',
        'Roystonea borinquena',
        'Moringa oleifera',
        'Roystonea oleracea',
        'Socratea exorrhiza',
        'Ficus elastica',
        'Areca vestiaria'
    ];

    public function run()
    {
        $this->faker = FactoryFaker::create();
        $this->createTaxaGroups();
    }

    private function createKingdoms() {
        $animalia = TaxonomyRankKingdom::firstOrCreate(['rank_name' => 'Animalia']);
        $plantae = TaxonomyRankKingdom::firstOrCreate(['rank_name' => 'Plantae']);
        $kingdoms = [$animalia, $plantae];
        return $kingdoms;
    }
    
    private function createTaxaGroups()
    {
        $kingdoms = $this->createKingdoms();
        for ($i = 0; $i < 15; $i ++)
            $this->createTaxonomyRank($kingdoms);
    }

    private function createTaxonomyRank($kingdoms)
    {
        $kingdom_index = array_rand($kingdoms, 1);
        $obj_kingdom = $kingdoms[$kingdom_index];

        $obj_class = TaxonomyRankClass::firstOrCreate(['rank_name' => $this->faker->sentence(3, true)]);
        $obj_family = TaxonomyRankFamily::firstOrCreate(['rank_name' => $this->faker->sentence(3, true)]);
        $obj_genus = TaxonomyRankGenus::firstOrCreate(['rank_name' => $this->faker->sentence(3, true)]);
        $obj_order = TaxonomyRankOrder::firstOrCreate(['rank_name' => $this->faker->sentence(3, true)]);
        $obj_phylum = TaxonomyRankPhylum::firstOrCreate(['rank_name' => $this->faker->sentence(3, true)]);

        if ($kingdom_index == 0) {
            // Animalia
            $aux = $this->animalia_species[array_rand($this->animalia_species, 1)];
            $obj_species = TaxonomyRankSpecie::firstOrCreate(['rank_name' => $aux]);
        } elseif ($kingdom_index == 1) {
            // Plantae
            $aux = $this->plantae_species[array_rand($this->plantae_species, 1)];
            $obj_species = TaxonomyRankSpecie::firstOrCreate(['rank_name' => $aux]);
        }

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
