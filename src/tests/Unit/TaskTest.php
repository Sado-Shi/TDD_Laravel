<?php

namespace Tests\Unit;

use App\Task;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use DatabaseTransactions;

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

    /**
     * Tasksテーブルから各詳細画面でタスクの詳細が取得できるか
     *
     * @return void
     */
    public function testGetTaskShow()
    {
        // 2番目に保存されている「テストタスク」のデータを取得
        $testTask = Task::find(2);
        $this->assertEquals('テストタスク', $testTask->title);
    }

    /**
     * 存在しないタスクのidを取得した場合空を返すか
     *
     * @return void
     */
    public function testGetTaskShowNotExists()
    {
        $task = Task::find(0);
        $this->assertNull($task);
    }

    // タスクがアップデートできるか
    public function testUpdateTask()
    {
        $task = Task::create([
            'title' => 'test',
            'executed' => false,
        ]);

        $this->assertEquals('test', $task->title);
        $this->assertFalse($task->executed);

        $task->fill([
            'title' => 'test2',
        ]);
        $task->save();

        $task2 = Task::find($task->id);
        $this->assertEquals('test2', $task2->title);
    }
}
