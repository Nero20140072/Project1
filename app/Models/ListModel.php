<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ListModel extends Model
{
    protected $table = "lists";

    protected $fillable = [
        'name',
    ];

    public function tasks()
    {
        return $this->hasMany('TaskModel');
    }
}
