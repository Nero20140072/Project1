<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    protected $table = "tasks";
    public $timestamps = false;

    protected $fillable = [
        'list_id',
        'name',
        'description',
        'priority',
        'mark'
    ];

    public function list()
    {
        return $this->belongsTo('ListModel');
    }
}
