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
        Schema::create('chat_conversations', function (Blueprint $table) {
            $table->bigInteger('id_chat_conversations')->autoIncrement();
            $table->bigInteger('user_id');

            $table->string('title', 150)->nullable();
            $table->boolean('is_active')->default(true);

            $table->dateTime('register_date')->useCurrent();
            $table->dateTime('updated_date')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id')
                ->references('id_users')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_conversations');
    }
};
