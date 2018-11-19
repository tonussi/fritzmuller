<?php
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use App\Member;
use App\Project;

class MemberSeeder extends Seeder
{
    private $faker;

    public function run()
    {
        $this->faker = FactoryFaker::create();
        $this->createProjects();
        $this->createMembers();
    }

    private function createProjects()
    {
        for ($i = 0; $i < 5; $i ++)
            $this->createProject();
    }

    private function createMembers()
    {
        for ($i = 0; $i < 5; $i ++)
            $this->createMember();
    }

    private function createProject()
    {
        Project::create([
            'project_description' => $this->faker->sentence(6, true),
            'figure_path' => 'https://placeimg.com/400/400/nature',
            'project_name' => $this->faker->sentence(6, true)
        ]);
    }

    private function createMember()
    {
        $arr_a = Project::all()->pluck('id')->shuffle()->all();
        Member::create([
            'project_id' => $arr_a[0],
            'member_name' => $this->faker->sentence(3, true),
            'member_description' => $this->faker->sentence(6, true),
            'grad' => $this->faker->sentence(6, true),
            'figure_path' => 'https://placeimg.com/400/400/people'
        ]);
    }
}
