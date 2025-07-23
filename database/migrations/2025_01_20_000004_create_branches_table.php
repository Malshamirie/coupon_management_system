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
    Schema::create('branches', function (Blueprint $table) {
      $table->id();
      $table->string('branch_number')->unique();
      $table->string('branch_name');
      $table->string('contact_number');
      $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
      $table->string('area'); // المنطقة | الحي | الشارع
      $table->text('google_map_link')->nullable();
      $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('branches');
  }
};
