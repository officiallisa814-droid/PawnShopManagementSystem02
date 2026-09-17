<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 255);
            $table->enum('gender', ['M', 'F']);
            $table->date('dob')->nullable();
            $table->string('passport_id', 100)->nullable();
            $table->string('phone_number', 50);
            $table->string('email', 255)->nullable()->unique();
            $table->string('address_house', 100)->nullable();
            $table->string('address_street', 100)->nullable();
            $table->string('address_village', 150)->nullable();
            $table->string('address_district', 150)->nullable();
            $table->string('address_province', 150)->nullable();
            $table->string('guarantor_name', 255)->nullable();
            $table->string('guarantor_phone', 50)->nullable();
            $table->integer('active_pledges')->default(0);
            $table->string('customer_type', 50)->default('regular');
            $table->string('customer_status', 50)->default('active');
            $table->string('id_card_photo', 255)->nullable();
            $table->string('customer_avatar', 255)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
