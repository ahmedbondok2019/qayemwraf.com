<?php

namespace Tests\Feature;

use App\Models\Setting;
use Tests\TestCase;

class AboutSectionTest extends TestCase
{
    public function test_setting_returns_default_about_section()
    {
        $setting = Setting::first() ?: new Setting();
        $about = $setting->getAboutSectionFormatted('ar');

        $this->assertIsArray($about);
        $this->assertNotEmpty($about['title']);
        $this->assertNotEmpty($about['stats']);
        $this->assertCount(4, $about['stats']);
        $this->assertCount(3, $about['features']);
        $this->assertNotEmpty($about['image_1']);
    }

    public function test_api_home_endpoint_contains_about_section()
    {
        $response = $this->getJson('/api/v1/home');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data' => [
                    'about_section' => [
                        'tag',
                        'title',
                        'highlight_text',
                        'description',
                        'stats',
                        'features',
                        'image_1',
                        'image_2',
                        'image_3',
                        'experience_years',
                        'experience_title',
                        'experience_subtitle',
                    ]
                ]
            ]);
    }
}
