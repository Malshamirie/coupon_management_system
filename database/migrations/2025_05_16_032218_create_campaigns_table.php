<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up():void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            //(بيانات الحملة)
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('manager_name');
            // نوع القسيمة: 1=قيمة ثابتة، 2=نسبة، 3=كاش باك، 4=خصم على فاتورة ثانية
            $table->enum('coupon_type', ['fixed', 'percentage', 'cashback', 'second_invoice_discount']);
            // إعدادات طريقة البحث (phone/email) والتحقق OTP والدومين
            $table->enum('search_method', ['phone', 'email']);
            $table->boolean('otp_required')->default(false);
            $table->string('email_domain')->nullable();

            $table->string('id_template')->nullable();
            $table->string('whatsapp_image_url')->nullable();

            // بيانات المستفيد
            $table->string('beneficiary')->nullable();         // اسم الشركة / المستفيد
            $table->string('beneficiary_manager')->nullable(); // اسم المسؤول للمستفيد
            $table->string('beneficiary_contact')->nullable(); // رقم تواصل المسؤول للمستفيد
            $table->text('terms')->nullable();//// الشروط الإضافية للتعاقد

            // بيانات واجهة المستخدم
            $table->string('logo')->nullable();          // شعار الصفحة
            $table->text('main_text')->nullable();       // النص الرئيسي قبل الفورم
            $table->text('sub_text')->nullable();        // النص الفرعي قبل الفورم
            $table->text('footer_text')->nullable();     // النص بعد الفورم
            $table->string('redirect')->nullable();      // رابط إعادة التوجيه
            $table->foreignId('container_id')->constrained('containers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
