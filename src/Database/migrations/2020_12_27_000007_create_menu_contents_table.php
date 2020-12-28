<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuContentsTable extends Migration
{
    /**
     * Run the migrations.min
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id');
            $table->integer('language_id');
            $table->tinyInteger('status');
            $table->string('name');
            $table->string('target');
            $table->tinyInteger('type');
            $table->integer('url_id');
            $table->text('out_link');
            $table->integer('parent');
            $table->integer('lft');
            $table->integer('rgt');
            $table->integer('depth');
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
        Schema::dropIfExists('menu_contents');
    }
}
