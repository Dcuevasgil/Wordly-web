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
            $table->bigInteger('id_user_words')->autoIncrement();

            $table->bigInteger('user_id');
            $table->bigInteger('word_id');

            $table->integer('times_correct')->default(0);
            $table->integer('times_failed')->default(0);
            $table->integer('times_reviewed')->default(0);
            $table->integer('days_interval')->default(1);
            $table->integer('mastered_level')->default(0);

            $table->decimal('ease_factor', 3,2)->default(2.50);

            $table->dateTime('last_review')->nullable();
            $table->dateTime('next_review')->nullable();


            $table->timestamp('register_date')->useCurrent();
            $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate();

            // UNIQUE (user_id, word_id)
            $table->unique(['user_id', 'word_id']);

            $table->foreign('user_id')->references('id_users')->on('users')->onDelete('cascade');
            $table->foreign('word_id')->references('id_words')->on('words')->onDelete('cascade');
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
