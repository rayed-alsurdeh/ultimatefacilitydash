<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',200);
            $table->string('description',500);
            $table->integer('state');
            $table->string('city',200);
            $table->string('suburb',200);
            $table->string('address',200);
            $table->string('mobile',15)->nullable();
            $table->string('phone',15)->nullable();
            $table->string('fax',15)->nullable();
            $table->string('img',200)->nullable();
            $table->integer('supervisor')->nullable();
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
        Schema::dropIfExists('site');
    }
}
