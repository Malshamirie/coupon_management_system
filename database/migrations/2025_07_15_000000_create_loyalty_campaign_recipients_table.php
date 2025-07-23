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
    Schema::create('loyalty_campaign_recipients', function (Blueprint $table) {
      $table->id();
      $table->foreignId('loyalty_campaign_id')->constrained('loyalty_campaigns')->onDelete('cascade');
      $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
      $table->string('phone_number');
      $table->enum('status', ['sent', 'delivered', 'failed'])->default('sent');
      $table->string('message_id')->nullable(); // من WhatsApp API
      $table->text('error_message')->nullable(); // رسالة الخطأ في حالة الفشل
      $table->integer('retry_count')->default(0); // عدد محاولات الإرسال
      $table->timestamp('sent_at')->useCurrent();
      $table->timestamp('delivered_at')->nullable();
      $table->timestamp('failed_at')->nullable();
      $table->timestamps();

      // فهارس للبحث السريع
      $table->index(['loyalty_campaign_id', 'status']);
      $table->index(['phone_number']);
      $table->index(['sent_at']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('loyalty_campaign_recipients');
  }
};
