<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
      $response = $this->json('POST', '/api/',
        ["Pete"=> "Nick",
           "Barbara"=> "Nick",
           "Nick"=> "Sophie",
           "Sophie"=> "Jonas"]);



        $response
            ->assertStatus(200)
            ->assertJson(['Jonas' => [
                                'Sophie' => [

                                        'Nick' => [
                                                'Pete' => [],

                                                'Barbara' => []

                                            ]

                                    ]

                            ]
                          ]);
    }
}
