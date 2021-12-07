<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('website_id')->index()->constrained()->onDelete('cascade');
            $table->tinyInteger('status')->default(2);
            $table->string('key')->unique();
            $table->string('type');
            $table->boolean('has_detail')->default(1);
            $table->boolean('has_category')->default(0);
            $table->boolean('has_property')->default(0);
            $table->boolean('has_url')->default(1);
            $table->boolean('is_searchable')->default(1);
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
        Schema::dropIfExists('structures');
    }
}
