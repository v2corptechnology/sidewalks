<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePanoramasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {            
        Schema::create('panoramas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('path_id')->references('id')->on('paths');
            $table->string('image');
            $table->json('exif')->nullable();
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
        Schema::dropIfExists('panoramas');
    }
}
