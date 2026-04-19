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
        Schema::create('exercises_answers', function (Blueprint $table) {
            $table->bigIncrements('id_exercises');
            $table->foreignId('exercise_id')->constrained('exercises', 'id_exercises')->cascadeOnDelete();

            $table->text('answer');
            $table->boolean('is_correct_answer');

            $table->text('explanation');

            // Timestamps personalizados
            $table->dateTime('register_date')->useCurrent();
            $table->dateTime('updated_date')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises_answers');
    }
};
