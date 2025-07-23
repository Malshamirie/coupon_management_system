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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('value_type', ['percentage', 'fixed'])->default('fixed'); // نوع القيمة (نسبة مئوية - قيمة ثابتة)
            $table->boolean('status')->default(1);
            // $table->unsignedBigInteger('container_id')->nullable();
            $table->foreignId('container_id')->constrained('containers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
