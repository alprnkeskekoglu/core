<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryPagesTable extends Migration
{
    /**
     * Run the migrations.min
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_pages', function (Blueprint $table) {
            $table->integer('category_id');
            $table->integer('page_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_pages');
    }
}
