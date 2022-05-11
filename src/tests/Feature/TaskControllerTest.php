<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    /**
     * すべてのタスクを取得するパスが正しく動くか
     *
     * @return void
     */
    public function testGetAllTasksPath()
    {
        $response = $this->get('/tasks');

        $response->assertStatus(200);
    }
}
