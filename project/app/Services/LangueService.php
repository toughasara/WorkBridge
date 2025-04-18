<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LangueService
{
    public static function fetchLangues()
    {
        $response = Http::get('https://restcountries.com/v3.1/all?fields=languages');

        if ($response->successful()) {
            $data = $response->json();
            $langues = [];

            foreach ($data as $country) {
                if (isset($country['languages'])) {
                    foreach ($country['languages'] as $code => $langue) {
                        $langues[$code] = $langue; 
                    }
                }
            }

            return array_values(array_unique($langues));
        }

        return [];
    }
}
