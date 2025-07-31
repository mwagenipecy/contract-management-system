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
        Schema::create('reminder_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Government Licenses", "Events", "Contracts"
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->default('bell');
            $table->string('color', 7)->default('#6366f1');
            
            // Type-specific configurations
            $table->enum('reminder_type', ['license', 'event', 'contract', 'task', 'maintenance', 'financial', 'training', 'welfare'])->default('task');
            $table->json('required_fields')->nullable(); // Fields required for this category type
            $table->json('optional_fields')->nullable(); // Optional fields for this category type
            $table->json('default_notification_periods')->nullable(); // [30, 7, 1] days before
            $table->json('notification_methods')->nullable(); // ['email', 'sms', 'system']
            
            $table->boolean('has_start_end_dates')->default(false); // Licenses, contracts need start/end
            $table->boolean('is_renewable')->default(false); // Can be renewed after expiry
            $table->boolean('is_recurring')->default(false); // Repeats automatically
            $table->boolean('requires_approval')->default(false); // Needs approval workflow
            
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_categories');
    }
};
