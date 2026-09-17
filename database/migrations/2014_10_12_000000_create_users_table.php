<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations to create the table.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            
            // 1. Add user role column (admin, manager, customer)
            $table->enum('role', ['admin', 'manager', 'customer'])->default('customer');
            
            // 2. Link account to customers table (nullable for staff users)
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('cascade');
            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations to drop the table.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
