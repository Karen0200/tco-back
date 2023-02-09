<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\TaskRequest;


class TaskController extends Controller
{

    public function __construct()
    {
        $this->middleware("auth");
    }


    public function index(Request $request)
    {
        $filter = $request->query('filter');
        if ($filter){
            $tasks = Task::query()
                ->where("front_date", "=", $filter)
                ->where("user_id", auth()->id())->get();
            return response()->json(["tasks" => $tasks]);
        }else{
            $tasks = Task::where("user_id", auth()->id())->get();
            return response()->json(["tasks" => $tasks]);
        }
    }


    public function store(TaskRequest $request)
    {
        $data = [
            "title" => $request["title"],
            "description" => $request["description"],
            "user_id" => auth()->id(),
            "status" => $request["status"],
            "front_date" => $request["front_date"],
        ];

        $newTask = Task::create($data);
        if ($newTask) {
            return response()->json("New task created");
        }
    }


    public function show(Task $task)
    {
        if (auth()->id() !== $task->user_id){
            return response()->json(["message" => "undefined user"]);
        }else{
            return response()->json($task);
        }

    }


    public function update(Request $request, Task $task)
    {
        if (auth()->id() !== $task->user_id) {
            return response()->json(["message" => "undefined user"]);
        } else {
            $data = [
                "title" => $request["title"],
                "description" => $request["description"],
                "user_id" => auth()->id(),
                "status" => $request["status"],
                "front_date" => $request["front_date"],
            ];

            $updated = $task->update($data);
            if ($updated) {
                return response()->json(["message" => "updated successfully"]);
            }
        }
    }

    public function destroy(Task $task)
    {
        if (auth()->id() !== $task->user_id) {
            return response()->json(["message" => "undefined user"]);
        } else {
            $deleted = $task->delete();

            if ($deleted) {
                return response()->json(["message" => "Task deleted"]);
            }
        }
    }
}
