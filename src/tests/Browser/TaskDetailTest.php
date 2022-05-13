<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TaskDetailTest extends DuskTestCase
{
    /**
     * Task Detail Test.
     *
     * @throws \Throwable
     */
    public function testShowDetail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/tasks/2')
                ->assertSee('テストタスク')
                ->screenshot("task_detail");
        });
    }
}
