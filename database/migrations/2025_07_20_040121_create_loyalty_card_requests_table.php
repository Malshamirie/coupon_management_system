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
        Schema::create('loyalty_card_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loyalty_campaign_id')->constrained('loyalty_campaigns')->onDelete('cascade');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('customer_address')->nullable();
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected', 'delivered'])->default('pending');
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('processed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['loyalty_campaign_id', 'status']);
            $table->index(['customer_phone']);
            $table->index(['branch_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_card_requests');
    }
};