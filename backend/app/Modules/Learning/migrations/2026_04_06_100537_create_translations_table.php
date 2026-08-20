<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->bigInteger('id_translations')->autoIncrement();
            $table->bigInteger('word_id');
            $table->bigInteger('target_language_id');


            $table->string('translation', 255);

            $table->text('example')->nullable();


            $table->timestamp('register_date')->useCurrent();
            $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate();


            $table->foreign('word_id')->references('id_words')->on('words')->onDelete('cascade');

            $table->foreign('target_language_id')->references('id_languages')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
