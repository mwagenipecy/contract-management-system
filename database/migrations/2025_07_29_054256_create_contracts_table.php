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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('contract_number')->unique();
            $table->enum('contract_type', ['full_time', 'part_time', 'contract', 'internship']);
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('salary', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->enum('status', ['draft', 'active', 'expired', 'terminated', 'pending_renewal'])->default('draft');
            $table->text('terms_and_conditions')->nullable();
            $table->integer('renewal_notice_period')->default(30); // days
            $table->boolean('auto_renewal')->default(false);
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->string('termination_reason')->nullable();
            $table->date('termination_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
