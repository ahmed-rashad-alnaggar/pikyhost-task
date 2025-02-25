<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Illuminate\Database\Seeder;

class PageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $landingPageHeroSection = [
            'page_id' => 1,
            'type' => 'hero',
            'content' => [
                'tagline' => 'TOP WEB DESIGN AGENCY',
                'main_heading' => 'WE GROW BRANDS ONLINE',
                'sub_heading' => 'Custom Websites, Branding & Digital Marketing Solutions.',
                'cta_text' => 'SPEAK WITH OUR EXPERTS',
                'cta_type' => 'section',
                'cta_link' => '#contact',
                'background_images' => [
                    'images/pages/landing/hero-section/thumbnails/1.jpg',
                    'images/pages/landing/hero-section/thumbnails/2.jpg',
                    'images/pages/landing/hero-section/thumbnails/3.jpg',
                    'images/pages/landing/hero-section/thumbnails/4.jpg',
                    'images/pages/landing/hero-section/thumbnails/5.jpg',
                    'images/pages/landing/hero-section/thumbnails/6.jpg',
                    'images/pages/landing/hero-section/thumbnails/7.jpg',
                    'images/pages/landing/hero-section/thumbnails/8.jpg',
                    'images/pages/landing/hero-section/thumbnails/9.jpg',
                    'images/pages/landing/hero-section/thumbnails/10.jpg',
                    'images/pages/landing/hero-section/thumbnails/11.jpg',
                    'images/pages/landing/hero-section/thumbnails/12.jpg',
                ],
                'slider_images' => [
                    'images/pages/landing/hero-section/logos/1.png',
                    'images/pages/landing/hero-section/logos/2.png',
                    'images/pages/landing/hero-section/logos/3.png',
                    'images/pages/landing/hero-section/logos/4.png',
                    'images/pages/landing/hero-section/logos/5.png',
                    'images/pages/landing/hero-section/logos/6.png',
                    'images/pages/landing/hero-section/logos/7.png',
                    'images/pages/landing/hero-section/logos/8.png',
                    'images/pages/landing/hero-section/logos/9.png',
                    'images/pages/landing/hero-section/logos/10.png',
                    'images/pages/landing/hero-section/logos/11.png',
                    'images/pages/landing/hero-section/logos/12.png',
                ],
            ],
        ];

        $landingPageAboutSection = [
            'page_id' => 1,
            'type' => 'about',
            'content' => [
                'heading' => 'Transforming Ideas into Digital Success',
                'description' => 'We craft unique digital experiences that elevate your brand. From custom website development and impactful branding to data-driven digital marketing strategies, we help businesses stand out and thrive in the online world. Let’s bring your vision to life with innovative solutions tailored to your needs.',
                'illustration' => 'images/pages/landing/about-section/illustration.svg',
            ],
        ];

        $landingPageContactSection = [
            'page_id' => 1,
            'type' => 'contact',
            'content' => [
                'heading' => 'Ask about our hot deals!',
                'phone' => '012-3456-7891',
                'email' => 'inquire@example.com',
                'address' => '12 st, District, Governorate',
                'cta_text' => 'Inquire Now!',
                'cta_email' => 'inquire@example.com',
            ],
        ];

        PageSection::create($landingPageHeroSection);
        PageSection::create($landingPageAboutSection);
        PageSection::create($landingPageContactSection);
    }
}
