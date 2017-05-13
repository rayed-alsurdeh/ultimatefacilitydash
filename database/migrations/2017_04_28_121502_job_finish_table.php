<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobFinishTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobfinish', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jobid');
            $table->integer('nch')->default(0);
            $table->integer('nct')->default(0);
            $table->integer('ncp')->default(0);
            $table->integer('sch')->default(0);
            $table->integer('sct')->default(0);
            $table->integer('scp')->default(0);
            $table->integer('ach')->default(0);
            $table->integer('act')->default(0);
            $table->integer('acp')->default(0);
            $table->String('ocd');
            $table->integer('oct')->default(0);
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
        Schema::dropIfExists('jobfinish');
    }
}
