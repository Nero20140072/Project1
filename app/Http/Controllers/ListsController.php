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
        $List = ListModel::find($id);
        if (is_null($List)) {
            return response()->json([
                'error' => true,
                'message' => 'List does not exist'
            ], 404);
        }
        return response()->json($List, 200);
    }

//Создание листа:
    public function addList(Request $req)
    {
        $rules = [
            'name'=>'required|min:1',
        ];
        $validator = Validator::make($req->all(),$rules);
        if ($validator->fails()){
            return response()->json([$validator->errors()], 400);
        }

        $List = ListModel::create($req->all());
        return response()->json($List, 201);
    }

//Редактирование листа:
    public function listEdit(Request $req, $id)
    {
        $rules = [
            'name'=>'required|min:1',
        ];
        $validator = Validator::make($req->all(),$rules);
        if ($validator->fails()) {
            return response()->json([$validator->errors()], 400);
        }

        $List = ListModel::find($id);
        if (is_null($List)){
            return response()->json(['error' => true, 'message' => 'List not found'], 404);
        }
        $List->update($req->all());
        return response()->json($List, 200);
    }

    //Удаление листа по ID:
    public function listDelete(Request $req, $id)
    {
        $List = ListModel::find($id);
        if (is_null($List)){
            return response()->json([
                'error'=>true,
                'message'=>'List not found'
            ], 404);
        }
        $List->delete();
        return response()->json('', 200);
    }

    //Проставление метки об открытом листе
    public function markIsOpen(Request $req, $id)
    {
        $List = ListModel::find($id);
        if ($List->isOpen=='true'){
            $List->isOpen='false';
        }
        else {
            $List->isOpen='true';
        }
        $List->save();
    }
}
