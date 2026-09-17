<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_schedules', function (Blueprint $table) {
            $table->id();
            // ភ្ជាប់ទៅកាន់ ID របស់ទំនិញបញ្ចាំ
            $table->foreignId('pawn_item_id')->constrained('pawn_items')->onDelete('cascade');
            
            $table->integer('term_number'); // វគ្គទីប៉ុន្មាន (ឧទាហរណ៍៖ ខែទី១, ខែទី២...)
            $table->date('due_date');       // ថ្ងៃដែលត្រូវបង់ប្រាក់
            $table->decimal('interest_amount', 10, 2); // ចំនួនទឹកប្រាក់ការប្រាក់ដែលត្រូវបង់
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid'); // ស្ថានភាពបង់ប្រាក់
            $table->date('paid_date')->nullable(); // ថ្ងៃដែលបានមកបង់ពិតប្រាកដ
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_schedules');
    }
};
