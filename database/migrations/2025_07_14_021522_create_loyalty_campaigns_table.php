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
        Schema::create('loyalty_campaigns', function (Blueprint $table) {
            $table->id();

            // إعدادات الحملة
            $table->foreignId('loyalty_card_id')->constrained('loyalty_cards')->onDelete('cascade');
            $table->foreignId('container_id')->constrained('containers')->onDelete('cascade');
            $table->string('campaign_name'); // اسم الحملة ( )
            $table->date('start_date');
            $table->date('end_date');
            $table->string('manager_name'); // اسم الموظف المسؤول

            // إعدادات رحلة العميل
            $table->enum('sending_method', ['whatsapp', 'email']);
            $table->string('whatsapp_template_id')->nullable(); // معرف قالب الواتساب
            $table->string('whatsapp_image_url')->nullable(); // رابط الصورة للواتساب
            $table->text('email_template')->nullable(); // قالب البريد الإلكتروني
            $table->text('additional_terms')->nullable(); // الشروط الإضافية

            // بيانات واجهة المستخدم
            $table->string('page_logo')->nullable(); // شعار الصفحة
            $table->text('main_text')->nullable(); // النص الرئيسي قبل النموذج
            $table->text('sub_text')->nullable(); // النص الفرعي قبل النموذج
            $table->text('after_form_text')->nullable(); // النص بعد النموذج
            $table->string('redirect_url')->nullable(); // رابط إعادة التوجيه

            // حالة الحملة
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_campaigns');
    }
};