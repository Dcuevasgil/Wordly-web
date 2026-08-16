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
        Schema::create('exercise_attempts', function (Blueprint $table) {
            $table->bigIncrements('id_exercise_attempts');

            $table->foreignId('user_id')
                ->constrained('users', 'id_users')
                ->onDelete('cascade');

            $table->bigInteger('exercise_id');
            $table->foreign('exercise_id')
                ->references('id_exercises')->on('exercises')
                ->onDelete('cascade');

            $table->bigInteger('exercise_answer_id')->nullable();
            $table->foreign('exercise_answer_id')
                ->references('id_exercise_answers')->on('exercise_answers')
                ->nullOnDelete();

            $table->text('user_response');
            $table->boolean('is_user_response_correct');

            $table->integer('response_time_ms');
            $table->timestamp('attempt_date');


            // Timestamps personalizados
            $table->dateTime('register_date')->useCurrent();
            $table->dateTime('updated_date')->useCurrent()->useCurrentOnUpdate();

            $table->index(['user_id', 'exercise_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_attempts');
    }
};
