<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContainersTable extends Migration
{
    /**
     * Run the migrations.min
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('website_id');
            $table->tinyInteger('status');
            $table->string('key');
            $table->string('type');
            $table->tinyInteger('has_detail')->default(2);
            $table->tinyInteger('has_category')->default(2);
            $table->tinyInteger('is_searchable')->default(2);
            $table->string('cvar_1')->nullable();
            $table->string('cvar_2')->nullable();
            $table->string('cvar_3')->nullable();
            $table->integer('cint_1')->nullable();
            $table->integer('cint_2')->nullable();
            $table->integer('cint_3')->nullable();
            $table->text('ctext_1')->nullable();
            $table->text('ctext_2')->nullable();
            $table->date('cdate_1')->nullable();
            $table->date('cdate_2')->nullable();
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
        Schema::dropIfExists('containers');
    }
}
