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
        Schema::create('words', function (Blueprint $table) {
            $table->bigInteger('id_words')->autoIncrement();

            $table->bigInteger('origin_language_id');
            
            $table->string('text', 255);
            $table->integer('difficult')->default(1);
            
            $table->timestamp('register_date')->useCurrent();
            $table->timestamp('updated_date')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('origin_language_id')->references('id_languages')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('words');
    }
};
