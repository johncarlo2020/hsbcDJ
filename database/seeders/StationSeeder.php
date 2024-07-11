<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Station;
use App\Models\Regime;


class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Regime::create([
            'name' => 'MICELLAR WATER/CLEANSUNG BALM',
        ]);

        Regime::create([
            'name' => 'FACE WASH',
        ]);

        Regime::create([
            'name' => 'TONER',
        ]);

        Regime::create([
            'name' => 'SERUM',
        ]);

        Regime::create([
            'name' => 'MOISTURIZER',
        ]);

        Regime::create([
            'name' => 'SUNSCREEN',
        ]);

        Regime::create([
            'name' => 'NONE',
        ]);
        
        Station::create([
            'name' => 'SKINVENTURE',
            'description'=> 'Discover the underlying factors contributing to your skin concerns through interactive skin journey.'
        ]);

        Station::create([
            'name' => 'SUN PROTECT ZONE',
            'description'=> 'Understand your SPF coverage and explore various sunscreen formulations to discover the ideal sunscreen for your specific skin requirements.'

        ]);

        Station::create([
            'name' => 'SKIN BARRIER REBORN',
            'description' => 'Explore more about skin layers anatomy and hidden truth about skin barrier with
interactive creative visual.'
        ]);

        Station::create([
            'name' => 'BRIGHTENING SKIN SCIENCE',
            'description' => 'Gain a profound understanding of highly curated brightening ingredients, through an interactive display and scientific game.'

        ]);

        Station::create([
            'name' => 'SKIN SCIENCE CLINIC & PERSONALIZED ROBOSKIN',
            'description' => 'Get a personal skin consultation from dermatologists and skin experts, with the latest skin analyzer technology. And experience revolutionary Personalised RoboSkin™️ to get tailor-made skin solutions for your specific skin needs.'

        ]);

        Station::create([
            'name' => 'SKINVERSE LOUNGE',
            'description' => 'Claim your privilege refreshment after completing the journey at each station. Visit our Skinverse Lounge to redeem.'
        ]);
    }
}