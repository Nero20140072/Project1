<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id('id')->unsigned();
            $table->bigInteger('list_id')->unsigned()->default(1);;
            $table->foreign('list_id')
                ->references('id')
                ->on('lists')
                ->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->integer('priority');
            $table->boolean('mark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::dropIfExists('tasks');
        Schema::table('tasks', function ($table) {
            $table->dropForeign('tasks_list_id_foreign');
            $table->foreign('list_id')
                ->references('id')
                ->on('lists')
                ->onDelete('cascade');
        });
    }
}
