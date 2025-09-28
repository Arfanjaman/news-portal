<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FooterInfo;

class FooterInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FooterInfo::updateOrCreate(
            ['language' => 'en'],
            [
                'logo' => '/test',
                'description' => 'test',
                'copyright' => 'test'
            ]
        );
    }
}
