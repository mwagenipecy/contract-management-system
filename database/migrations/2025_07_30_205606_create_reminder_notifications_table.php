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
        Schema::create('reminder_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reminder_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees'); // Changed from user_id to employee_id
            
            $table->enum('notification_type', ['reminder', 'overdue', 'renewal', 'completion'])->default('reminder');
            $table->enum('method', ['email', 'sms', 'system', 'whatsapp'])->default('system');
            $table->integer('days_before')->nullable(); // Days before due date
            
            $table->timestamp('scheduled_at');
            $table->timestamp('sent_at')->nullable();
            $table->enum('status', ['pending', 'sent', 'failed', 'cancelled'])->default('pending');
            
            $table->text('message')->nullable();
            $table->json('metadata')->nullable(); // SMS gateway response, email tracking, etc.
            $table->string('external_reference')->nullable(); // SMS gateway message ID, etc.
            
            $table->timestamps();

            $table->index(['scheduled_at', 'status']);
            $table->index(['reminder_item_id', 'employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_notifications');
    }
};
