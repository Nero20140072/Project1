<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\ListModel;
use Validator;

class ListsController extends Controller
{

//Поиск листа по ID:
    public function listByID($id)
    {
        $list = ListModel::find($id);
        if (is_null($list))
        {
            return response()->json([
                'error' => true,
                'message' => 'List does not exist'
            ], 404);
        }
        return response()->json($list, 200);
    }

//Создание листа:
    public function addList(Request $req)
    {
        $rules = [
            'name' => 'required|min:1',
        ];
        $validator = Validator::make($req->all(),$rules);
        if ($validator->fails())
        {
            return response()->json([$validator->errors()], 400);
        }

        $list = ListModel::create($req->all());
        return response()->json($list, 201);
    }

//Редактирование листа:
    public function listEdit(Request $req, $id)
    {
        $rules = [
            'name' => 'required|min:1',
        ];
        $validator = Validator::make($req->all(),$rules);
        if ($validator->fails()) {
            return response()->json([$validator->errors()], 400);
        }

        $list = ListModel::find($id);
        if (is_null($list))
        {
            return response()->json([
                'error' => true,
                'message' => 'List not found'
            ], 404);
        }
        $list->update($req->all());
        return response()->json($list, 200);
    }

    //Удаление листа по ID:
    public function listDelete(Request $req, $id)
    {
        $list = ListModel::find($id);
        if (is_null($list))
        {
            return response()->json([
                'error' => true,
                'message' => 'List not found'
            ], 404);
        }
        $list->delete();
        return response()->json('', 200);
    }
}
