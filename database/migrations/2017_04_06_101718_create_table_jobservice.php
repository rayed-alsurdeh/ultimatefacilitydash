<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJobservice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobservice', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jobid');
            $table->integer('gtype');
            $table->integer('type');
            $table->integer('room')->default(0);
            $table->integer('rmst')->default(0);
            $table->integer('rend')->default(0);
            $table->string('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobservice');
    }
}
