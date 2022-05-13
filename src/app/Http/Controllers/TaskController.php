<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return view('tasks.index', compact('tasks'));
    }

    public function show(int $id)
    {
        // idが存在しない場合は404を返す
        $task = Task::find($id);
        if ($task === null) {
            abort(404);
        }

        return view('tasks.show', [
            'task' => Task::find($id),
        ]);
    }

    public function update(Request $request, int $id)
    {
        // idが存在しない場合は404を返す
        $task = Task::find($id);
        if ($task === null) {
            abort(404);
        }

        $fillData = [];
        if (isset($request->title)) {
            $fillData['title'] = $request->title;
        }
        if (isset($request->executed)) {
            $fillData['executed'] = $request->executed;
        }

        if (count($fillData) > 0) {
            $task->fill($fillData);
            $task->save();
        }

        return redirect('/tasks/' . $id);
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:512',
        ]);

        Task::create([
            'title' => $request->title,
            'executed' => $request->executed,
        ]);

        return redirect('/tasks');
    }

    public function destroy(int $id)
    {
        // idが存在しない場合は404を返す
        $task = Task::find($id);
        if ($task === null) {
            abort(404);
        }

        Task::destroy($id);

        return redirect('/tasks');
    }
}
