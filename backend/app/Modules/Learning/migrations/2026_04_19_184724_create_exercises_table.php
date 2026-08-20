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
        Schema::create('exercises', function (Blueprint $table) {
            $table->bigInteger('id_exercises')->autoIncrement();

            $table->string('type_exercise', 50);
            $table->string('topic_exercise', 100);

            $table->text('question');
            $table->text('explanation')->nullable();

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
        Schema::dropIfExists('exercises');
    }
};
