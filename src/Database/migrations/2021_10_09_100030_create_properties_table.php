<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('container_id')->index();
            $table->tinyInteger('status')->default(2);
            $table->string('cvar_1')->nullable();
            $table->integer('cint_1')->nullable();
            $table->text('ctext_1')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('container_id')->references('id')->on('containers')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
