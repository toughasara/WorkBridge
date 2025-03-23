<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            'PHP',
            'JavaScript',
            'Laravel',
            'Vue.js',
            'HTML',
            'CSS',
            'MySQL',
            'PostgreSQL',
            'Git',
            'Docker',
            'Node.js',
            'React'
        ];

        // Insérer les compétences dans la table skills
        foreach ($skills as $skill) {
            Skill::create(['name' => $skill]);
        }
    }
}
