<?php

namespace Tests\Unit;

use App\Task;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * Tasksテーブルからタスクが取得できるか
     *
     * @return void
     */
    public function testGetSeederTasks()
    {
        // タスク全件取得
        $tasks = Task::all();
        $this->assertEquals(18, count($tasks));

        // 実行完了していないものを取得
        $taskNotFinished = Task::where("executed", false)->get();
        $this->assertEquals(12, count($taskNotFinished));

        // 実行完了しているものを取得
        $taskFinished = Task::where("executed", true)->get();
        $this->assertEquals(6, count($taskFinished));

        // 「テストタスク」というタイトルのレコードを取得
        $testTask = Task::where('title', 'テストタスク')->first();
        $this->assertFalse(boolval($testTask->executed));

        // 「終了タスク」というタイトルのレコードを取得
        $finishedTask = Task::where('title', '終了タスク')->first();
        $this->assertTrue(boolval($finishedTask->executed));
    }
}
