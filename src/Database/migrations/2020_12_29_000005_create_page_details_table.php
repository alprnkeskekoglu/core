<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageDetailsTable extends Migration
{
    /**
     * Run the migrations.min
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id');
            $table->integer('language_id');
            $table->tinyInteger('status');
            $table->string('name');
            $table->string('slug');
            $table->text('detail');
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
        Schema::dropIfExists('page_details');
    }
}
