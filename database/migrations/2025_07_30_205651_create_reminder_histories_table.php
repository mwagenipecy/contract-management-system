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
        Schema::create('reminder_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reminder_item_id')->constrained()->onDelete('cascade');
            $table->date('previous_due_date');
            $table->date('new_due_date');
            $table->decimal('amount_paid', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->json('documents')->nullable(); // Renewal documents
            $table->foreignId('completed_by')->constrained('users');
            $table->timestamp('completed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_histories');
    }
};
