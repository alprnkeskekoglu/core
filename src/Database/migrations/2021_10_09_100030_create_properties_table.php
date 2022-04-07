<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->foreignId('structure_id')->index()->constrained()->onDelete('cascade');
            $table->foreignId('container_id')->index()->constrained()->onDelete('cascade');
            $table->tinyInteger('status')->default(2);
            $table->unsignedInteger('order')->nullable();
            $table->string('cvar_1')->nullable();
            $table->integer('cint_1')->nullable();
            $table->text('ctext_1')->nullable();
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
        Schema::dropIfExists('properties');
    }
};
