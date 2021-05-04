<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();           
            $table->string('name');
            $table->string('task_name')->references('name')->on('tasks');
            $table->bigInteger('task_id')->unsigned();
            $table->string('asssigned_user')->references('user_name')->on('tasks');
            $table->timestamps();
        });

        Schema::table('boards', function($table) {
            $table->foreign('task_id')->references('id')->on('tasks');
            
        });
    }

    // BAZA DE DATE PENTRU BOARDURI. ACEASTA VA FI UN MODAL CARE DA POSIBILITATEA USERULUI SA ADAUGE ALTI USERI,SA DENUMEASCA BOARD-UL SI TASKURILE CARE POT FI ASIGNATE USERILOR AFERENTI BOARDULUI

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
