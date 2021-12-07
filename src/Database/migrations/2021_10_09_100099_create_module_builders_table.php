<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleBuildersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module_builders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('structure_id')->index()->constrained()->onDelete('cascade');
            $table->string('type');
            $table->json('data');
            $table->json('meta_tags');
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
        Schema::dropIfExists('module_builders');
    }
}
