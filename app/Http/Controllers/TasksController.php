<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\TaskModel;
use Validator;

class TasksController extends Controller
{

//Поиск задачи по ID:
    public function taskByID($id)
    {
        $task = TaskModel::find($id);
        if (is_null($task))
        {
            return response()->json([
                'error' => true,
                'message' => 'Task does not exist'
            ], 404);
        }
        return response()->json($task, 200);
    }

//Создание задачи:
    public function addTask(Request $req)
    {
        $rules = [
            'priority' => 'required|min:1|max:2',
            'mark' => 'required|min:4',
        ];
        $validator = Validator::make($req->all(),$rules);
        if ($validator->fails()){
            return response()->json([$validator->errors()], 400);
        }

        $task = TaskModel::create($req->all());
        return response()->json($task, 201);
    }

//Редактирование задачи:
    public function taskEdit(Request $req, $id)
    {
        $rules = [
            'priority' => 'required|min:1|max:2',
            'mark' => 'required|min:4',
        ];
        $validator = Validator::make($req->all(),$rules);
        if ($validator->fails())
        {
            return response()->json([$validator->errors()],400);
        }

        $task = TaskModel::find($id);
        if (is_null($task))
        {
            return response()->json([
                'error' => true,
                'message' => 'Task not found'
            ], 404);
        }
        $task->update($req->all());
        return response()->json($task, 200);
    }

    //Удаление задачи по ID:
    public function taskDelete(Request $req, $id){
        $task = TaskModel::find($id);
        if (is_null($task))
        {
            return response()->json([
                'error' => true,
                'message' => 'Task not found'
            ], 404);
        }
        $task->delete();
        return response()->json('', 200);
    }

    //Проставление метки о выполненном задании
    public function mark(Request $req, $id){
        $task = TaskModel::find($id);
        if ($task->mark == 'true')
        {
            $task->mark = 'false';
        } else
            {
            $task->mark = 'true';
            }
        $task->save();
    }
}

