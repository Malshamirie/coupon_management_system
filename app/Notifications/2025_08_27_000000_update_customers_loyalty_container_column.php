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
        Schema::table('customers', function (Blueprint $table) {
            // حذف العمود القديم
            $table->dropForeign(['container_id']);
            $table->dropColumn('container_id');
            
            // إضافة العمود الجديد
            $table->foreignId('loyalty_container_id')->constrained('loyalty_containers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // حذف العمود الجديد
            $table->dropForeign(['loyalty_container_id']);
            $table->dropColumn('loyalty_container_id');
            
            // إعادة العمود القديم
            $table->foreignId('container_id')->constrained('containers')->onDelete('cascade');
        });
    }
};
