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
        Schema::create('user_paths', function (Blueprint $table) {
            $table->bigInteger('id_user_paths')->autoIncrement();

            $table->bigInteger('user_id');
            $table->bigInteger('learning_path_id');

            $table->enum('level', ['basic', 'intermediate', 'advanced']);
            $table->string('self_assessment', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('progress_percentage', 5, 2)->default(0.00);

            $table->dateTime('start_date')->useCurrent();
            $table->dateTime('last_access_date')->nullable();
            
            $table->foreign('user_id')->references('id_users')->on('users')->onDelete('cascade');
            $table->foreign('learning_path_id')->references('id_learning_paths')->on('learning_paths')->onDelete('cascade');

            $table->unique(['user_id', 'learning_path_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_paths');
    }
};
