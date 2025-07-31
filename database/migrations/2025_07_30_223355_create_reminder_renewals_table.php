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
        Schema::create('reminder_renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reminder_item_id')->constrained()->onDelete('cascade');
            $table->date('previous_start_date')->nullable();
            $table->date('previous_end_date');
            $table->date('new_start_date')->nullable();
            $table->date('new_end_date');
            $table->decimal('renewal_amount', 12, 2)->nullable();
            $table->string('renewal_reference')->nullable();
            $table->text('renewal_notes')->nullable();
            $table->json('renewal_documents')->nullable();
            $table->foreignId('renewed_by')->constrained('users');
            $table->timestamp('renewed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminder_renewals');
    }
};
