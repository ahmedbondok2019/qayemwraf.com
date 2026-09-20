<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\ProjectTranslation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiProjectTest extends TestCase
{
    public function test_projects_endpoint_returns_paginated_data()
    {
        $response = $this->getJson('/api/v1/projects?per_page=5');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'success',
                'code',
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'image',
                        'video',
                        'link',
                        'sort_order',
                        'created_at',
                    ]
                ],
                'current_page',
                'last_page',
                'per_page',
                'total',
                'meta',
                'links',
            ]);
    }

    public function test_projects_endpoint_supports_language_header_and_query()
    {
        $responseAr = $this->getJson('/api/v1/projects?lang=ar');
        $responseAr->assertStatus(200);

        $responseEn = $this->withHeaders(['lang' => 'en'])->getJson('/api/v1/projects');
        $responseEn->assertStatus(200);
    }

    public function test_projects_endpoint_supports_search()
    {
        $response = $this->getJson('/api/v1/projects?search=مشروع');
        $response->assertStatus(200);
    }
}
