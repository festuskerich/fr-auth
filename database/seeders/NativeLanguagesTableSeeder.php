<?php

namespace Database\Seeders;

use App\Models\NativeLanguage;
use App\Models\Subtribe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NativeLanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the JSON file
        $jsonFilePath = storage_path('app/tribes.json');
        // Read the JSON file content
        $jsonContent = file_get_contents($jsonFilePath);
        // Decode JSON content to array
        $dataArray = json_decode($jsonContent, true);
        foreach ($dataArray as $tribe) {
            $nativeLanguage = NativeLanguage::create([
                'name' => $tribe['name'],
                'description' => $tribe['description'],
                'residence' => $tribe['residence']
            ]);
            $array = $tribe['subtribes'];
            if (count($array) > 0) {
                foreach ($array as $subtribe) {
                    Subtribe::create([
                        'name' => $subtribe['name'],
                        'residence' => $subtribe['residence'] ?? $tribe['residence'],
                        'language_id' => $nativeLanguage->id
                    ]);
                }
            }
        }
    }
}
