<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerDetailsTable extends Migration
{
    /**
     * Run the migrations.min
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('container_id');
            $table->integer('language_id');
            $table->tinyInteger('status');
            $table->string('name');
            $table->string('slug');
            $table->text('detail')->nullable();
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
        Schema::dropIfExists('container_details');
    }
}
