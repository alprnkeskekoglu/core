<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormResultsTable extends Migration
{
    /**
     * Run the migrations.min
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('form_id');
            $table->string('email')->nullable();
            $table->tinyInteger('read')->default(2);
            $table->string('ip');
            $table->text('user_agent');
            $table->text('data');
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
        Schema::dropIfExists('form_results');
    }
}
