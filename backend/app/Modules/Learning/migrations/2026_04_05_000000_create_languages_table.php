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
        Schema::create('languages', function (Blueprint $table) {
            // PK personalizada
            $table->bigInteger('id_languages')->autoIncrement();

            // Campos
            $table->string('name', 100);
            $table->string('code', 10)->unique();

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
        Schema::dropIfExists('languages');
    }
};
