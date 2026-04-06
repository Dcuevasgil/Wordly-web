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
            $table->bigIncrements('id_translations');

            $table->foreignId('word_id')->constrained('words', 'id_words')->onDelete('cascade');
            $table->foreignId('target_language_id')->constrained('languages', 'id_languages')->onDelete('cascade');

            $table->string('translation', 255);

            $table->text('example')->nullable();


            $table->timestamp('register_date')->useCurrent();
            $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_words');
    }
};
