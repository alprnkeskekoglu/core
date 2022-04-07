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
        Schema::create('form_message_medias', function (Blueprint $table) {
            $table->foreignId('form_message_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('media_id')->index()->constrained('medias')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_message_medias');
    }
};;
