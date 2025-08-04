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
        Schema::create('promotion_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promotion_id')->index();
            $table->string('type');
            $table->string('recipient');
            $table->text('message');
            $table->string('status');
            $table->text('error_message')->nullable();
            $table->json('response_data')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_logs');
    }
};
