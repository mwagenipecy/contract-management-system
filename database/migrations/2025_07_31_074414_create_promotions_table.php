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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['promotion', 'announcement', 'update', 'alert', 'celebration'])->default('announcement');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['draft', 'scheduled', 'sent', 'cancelled'])->default('draft');
            
            // Date fields
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            
            // Recipients configuration
            $table->enum('recipient_type', ['all_employees', 'selected_employees', 'departments'])->default('all_employees');
            $table->json('selected_employees')->nullable();
            $table->json('selected_departments')->nullable();
            $table->integer('total_recipients')->default(0);
            $table->integer('actual_recipients')->nullable();
            
            // Delivery configuration
            $table->json('delivery_methods')->default('["email"]');
            $table->json('attachments')->nullable();
            
            // Status and metadata
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            // Indexes
            $table->index(['status', 'is_active']);
            $table->index(['type', 'priority']);
            $table->index(['scheduled_at']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
