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
            $table->integer('admin_id')->nullable();
            $table->integer('menu_id');
            $table->integer('language_id');
            $table->tinyInteger('status');
            $table->string('name');
            $table->tinyInteger('type');
            $table->integer('url_id')->nullable();
            $table->text('out_link')->nullable();
            $table->string('target')->nullable();
            $table->integer('parent_id')->default(0);
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
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
