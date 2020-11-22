<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ListModel extends Model
{
    protected $table = "lists";
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function tasks()
    {
        return $this->hasMany('TaskModel');
    }
}
