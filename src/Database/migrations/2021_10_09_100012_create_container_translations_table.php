<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainerTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('container_id')->index();
            $table->unsignedInteger('language_id')->index();
            $table->boolean('status')->default(1);
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('detail')->nullable();
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
        Schema::dropIfExists('container_translations');
    }
}
