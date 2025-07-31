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
        Schema::create('reminder_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('reminder_categories')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            
            // Date fields - dynamic based on category type
            $table->date('start_date')->nullable(); // For licenses, contracts
            $table->date('end_date')->nullable(); // For licenses, contracts
            $table->date('event_date')->nullable(); // For events, tasks
            $table->date('due_date'); // Main deadline/due date
            $table->date('renewal_date')->nullable(); // Next renewal date if applicable
            
            // Status and priority
            $table->enum('status', ['active', 'completed', 'overdue', 'cancelled', 'pending_approval'])->default('active');
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            
            // Assignment and notifications
            $table->json('assigned_employees')->nullable(); // Multiple employees can be assigned
            $table->json('notification_recipients')->nullable(); // Who receives notifications
            $table->json('notification_periods')->nullable(); // Custom notification periods
            $table->json('notification_methods')->nullable(); // email, sms, system
            
            // Financial information
            $table->decimal('amount', 12, 2)->nullable();
            $table->string('currency', 3)->default('TZS');
            $table->string('vendor_supplier')->nullable();
            $table->string('reference_number')->nullable(); // License number, contract number, etc.
            
            // Dynamic fields based on category type
            $table->json('custom_fields')->nullable(); // Store category-specific data
            
            // File attachments and notes
            $table->json('documents')->nullable();
            $table->text('notes')->nullable();
            $table->text('completion_notes')->nullable();
            
            // Tracking fields
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('last_notification_sent')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['due_date', 'status']);
            $table->index(['category_id', 'status']);
            $table->index(['start_date', 'end_date']);
            $table->index('event_date');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_items');
    }
};
