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
        Schema::create('exercise_answers', function (Blueprint $table) {
            $table->bigInteger('id_exercise_answers')->autoIncrement();
            $table->bigInteger('exercise_id');
            
            $table->text('answer');
            $table->boolean('is_correct_answer')->default(true);
            
            $table->text('explanation');
            
            // Timestamps personalizados
            $table->dateTime('register_date')->useCurrent();
            $table->dateTime('updated_date')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('exercise_id')->references('id_exercises')->on('exercises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_answers');
    }
};
