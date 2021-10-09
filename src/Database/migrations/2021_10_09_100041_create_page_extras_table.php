<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageExstrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_extras', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('page_id')->index();
            $table->string('key');
            $table->text('value');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('page_id')->references('id')->on('page_extras')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_extras');
    }
}