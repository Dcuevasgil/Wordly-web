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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->bigInteger('id_chat_messages')->autoIncrement();
            $table->bigInteger('conversation_id');

            $table->enum('role', ['user', 'assistant']);
            $table->text('content');

            $table->string('model', 50)->nullable();
            $table->integer('tokens_used')->nullable();
            $table->integer('latency_ms')->nullable();

            $table->dateTime('register_date')->useCurrent();

            $table->foreign('conversation_id')
                ->references('id_chat_conversations')
                ->on('chat_conversations')
                ->onDelete('cascade');
            
            $table->index(['conversation_id', 'register_date'], 'idx_chat_messages_conversation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
