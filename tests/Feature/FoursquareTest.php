<?php

namespace Tests\Feature;

use Tests\TestCase;

class FoursquareTest extends TestCase
{

    private $categoryId;

    public function testCategories()
    {


        $response = $this->json('GET', route('api.categories'));

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'response' => [
                'categories' => [
                    '*' => [
                        'name', 'categories',
                    ],
                ],
            ],

        ]);

        $content = $response->getOriginalContent();

        $this->categoryId = $content->response->categories[0]->id;


    }

    public function testExplore()
    {

        $params = [
            'categoryId' => $this->categoryId,
            'near'       => 'valletta',
            'radius'     => 1000,
        ];

        $response = $this->json('GET', route('api.explore'), $params);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'response' => [
                'totalResults',
                'groups' => [
                    '*' => [
                        'items' => [
                            '*' => [
                                'venue' => [
                                    'id',
                                    'name',
                                    'location',
                                    'categories',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);

    }
}
