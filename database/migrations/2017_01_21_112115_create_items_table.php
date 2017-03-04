<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->references('id')->on('users');
            $table->unsignedInteger('path_id')->references('id')->on('paths');
            $table->string('title');
            $table->text('description');
            $table->unsignedInteger('quantity');
            $table->bigInteger('amount');
            $table->string('symbol');
            $table->json('images')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
