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
        Schema::create('reminder_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reminder_item_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('employees');
            $table->enum('role', ['responsible', 'informed', 'approver', 'backup'])->default('responsible');
            $table->boolean('receives_notifications')->default(true);
            $table->json('notification_methods')->nullable(); // ['email', 'sms']
            $table->timestamps();

            $table->unique(['reminder_item_id', 'employee_id', 'role']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_assignments');
    }
};
