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
        Schema::create('user_words', function (Blueprint $table) {
            $table->id('id_user_words');
            $table->foreignId('user_id');
            $table->foreignId('word_id');

            $table->integer('times_correct');
            $table->integer('times_failed');
            $table->integer('times_reviewed');
            $table->integer('days_interval');
            $table->integer('mastered_level');

            $table->decimal('ease_factor');

            $table->dateTime('last_review');
            $table->dateTime('next_review');


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
