<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() : void
    {
        $landingPage = [
            'type' => 'landing',
            'title' => 'Piky Host - Home',
            'slug' => '/',
            'seo_keywords' => 'software,graphic design,marketing',
            'seo_description' => 'At PikyHost, we offer customized designs for logos, brochures, business cards, social media graphics, and much more.'
        ];

        Page::create($landingPage);
    }
}
