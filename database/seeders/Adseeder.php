<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ad;

class Adseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ad::updateOrCreate( //so that initially dummy data thakbe
            ['id' => 1],
            [
                'home_top_bar_ad' => 'test',
                'home_middle_ad' => 'test',
                'view_page_ad' => 'test',
                'news_page_ad' => 'test',
                'side_bar_ad' => 'test',
                'home_top_bar_ad_status' => '1',
                'home_middle_ad_status' => '1',
                'view_page_ad_status' => '1',
                'news_page_ad_status' => '1',
                'side_bar_ad_status' => '1',
                'home_top_bar_ad_url' => 'test',
                'home_middle_ad_url' => 'test',
                'view_page_ad_url' => 'test',
                'news_page_ad_url' => 'test',
                'side_bar_ad_url' => 'test',

            ]
        );
    }
}
