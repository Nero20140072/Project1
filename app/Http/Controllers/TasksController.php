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
        $Task=TaskModel::find($id);
        if (is_null($Task)){
            return response()->json([
                'error' => true,
                'message' => 'Task does not exist'
            ], 404);
        }
        return response()->json($Task, 200);
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

        $Task = TaskModel::create($req->all());
        return response()->json($Task, 201);
    }

//Редактирование задачи:
    public function taskEdit(Request $req, $id)
    {
        $rules = [
            'priority' => 'required|min:1|max:2',
            'mark' => 'required|min:4',
        ];
        $validator = Validator::make($req->all(),$rules);
        if ($validator->fails()){
            return response()->json([$validator->errors()],400);
        }

        $Task=TaskModel::find($id);
        if (is_null($Task)){
            return response()->json([
                'error'=>true,
                'message'=>'Task not found'
            ], 404);
        }
        $Task->update($req->all());
        return response()->json($Task, 200);
    }

    //Удаление задачи по ID:
    public function taskDelete(Request $req, $id){
        $Task=TaskModel::find($id);
        if (is_null($Task)){
            return response()->json([
                'error'=>true,
                'message'=>'Task not found'
            ], 404);
        }
        $Task->delete();
        return response()->json('', 200);
    }

    //Проставление метки о выполненном задании
    public function mark(Request $req, $id){
        $Task=TaskModel::find($id);
        if ($Task->mark=='true'){
            $Task->mark='false';
        }
        else {
            $Task->mark='true';
        }
        $Task->save();
    }
}

