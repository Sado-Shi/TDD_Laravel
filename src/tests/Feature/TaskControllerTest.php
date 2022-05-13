<?php

namespace Tests\Feature;

use App\Task;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    // use RefreshDatabase;
    use DatabaseTransactions;

    private $task;

    // テストケース実行前に実行
    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     $this->task = Task::create([
    //         'title' => 'テストタスク',
    //         'executed' => false,
    //     ]);
    // }

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

    /**
     * タスクの詳細を取得するパスが正しく動くか
     *
     * @return void
     */
    public function testShowTaskPath()
    {
        $response = $this->get('/tasks/1');

        $response->assertStatus(200);
    }

    /**
     * タスクの詳細を取得するパスが正しくない場合は404を返すか
     *
     * @return void
     */
    public function testShowTaskPathNotExists()
    {
        $response = $this->get('/tasks/0');

        $response->assertStatus(404);
    }

    /**
     * タスク更新するパスが正しく動くか
     *
     * @return void
     */
    public function testUpdateTaskPath()
    {
        $data = [
            'title' => 'task title',
        ];
        $this->assertDatabaseMissing('tasks', $data);

        $response = $this->put('/tasks/1', $data);

        $response->assertStatus(302)->assertRedirect('/tasks/1', $data);

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testPutTaskPath2()
    {
        $data = [
            'title' => 'テストタスク2',
            'executed' => true,
        ];
        $this->assertDatabaseMissing('tasks', $data);

        $response = $this->put('/tasks/2', $data);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/2');

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testCreateTaskPath()
    {
        $response = $this->get('/tasks/create');

        $response->assertStatus(200);
    }

    public function testStoreTaskPath()
    {
        $data = [
            'title' => 'test title',
            'executed' => false,
        ];
        $this->assertDatabaseMissing("tasks", (array) $data);

        $response = $this->post('/tasks', $data);

        $response->assertStatus(302)->assertRedirect('/tasks');

        $this->assertDatabaseHas("tasks", (array) $data);
    }

    /**
     * Post Task Path Test (Without Title)
     *
     * @return void
     */
    public function testPostTaskPathWithoutTitle_failed()
    {
        $data = [];
        $response = $this->from('/tasks/create')
            ->post('/tasks/', $data);

        $response->assertSessionHasErrors(['title' => 'The title field is required.']);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/create');
    }

    /**
     * Post Task Path Test (Empty Title)
     *
     * @return void
     */
    public function testPostTaskPathEmptyTitle_failed()
    {
        $data = [
            'title' => ''
        ];
        $response = $this->from('/tasks/create')
            ->post('/tasks/', $data);

        $response->assertSessionHasErrors(['title' => 'The title field is required.']);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/create');
    }

    /**
     * Post Task Path Test (Max Length)
     *
     * @return void
     */
    public function testPostTaskPathTitleMaxLength()
    {
        $data = [
            'title' => Str::random(512),
            'executed' => false,
        ];

        $this->assertDatabaseMissing('tasks', $data);

        $response = $this->post('/tasks', $data);

        $response->assertStatus(302)
            ->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', $data);
    }

    /**
     * Post Task Path Test (Max Length + 1)
     *
     * @return void
     */
    public function testPostTaskPathTitleMaxLengthPlus1_failed()
    {
        $data = [
            'title' => Str::random(513)
        ];

        $response = $this->from('/tasks/create')
            ->post('/tasks/', $data);

        $response->assertSessionHasErrors(['title' => 'The title may not be greater than 512 characters.']);

        $response->assertStatus(302)
            ->assertRedirect('/tasks/create');
    }

    /**
     * Post Task Path Test (Max Length + 1)
     *
     * @return void
     */
    public function testDeleteTaskPath()
    {
        $data = [
            'id' => 2,
            'title' => 'テストタスク',
            'executed' => false,
        ];

        $this->assertDatabaseHas('tasks', $data);

        $response = $this->from('/tasks/{id}')
            ->delete('/tasks/' . $data['id']);

        $response->assertStatus(302)
            ->assertRedirect('/tasks');

        $this->assertDatabaseMissing('tasks', $data);
    }
}
