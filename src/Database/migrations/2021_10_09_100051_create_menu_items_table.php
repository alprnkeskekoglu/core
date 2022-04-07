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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->index()->constrained()->onDelete('cascade');
            $table->unsignedInteger('language_id')->index();
            $table->tinyInteger('status')->default(2);
            $table->unsignedInteger('parent_id')->default(0);
            $table->unsignedInteger('left')->default(0);
            $table->unsignedInteger('right')->default(0);
            $table->string('name');
            $table->tinyInteger('type');
            $table->unsignedInteger('url_id')->nullable()->index();
            $table->string('external_link')->nullable();
            $table->string('target')->nullable();
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
        Schema::dropIfExists('menu_items');
    }
};
