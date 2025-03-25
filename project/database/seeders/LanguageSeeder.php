<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;


class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            'Français',
            'Anglais',
            'Espagnol',
            'Allemand',
            'Italien',
            'Arabe',
            'Chinois',
            'Japonais',
            'Russe',
            'Portugais'
        ];

        foreach ($languages as $language) {
            Language::create(['name' => $language]);
        }
    }
}
