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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('username', 100);
            $table->string('password');
            $table->string('user_position', 50);
            $table->string('user_posid')->nullable();
            $table->string('sponser_id');
            $table->string('coupon_id')->nullable();
            $table->string('user_type', 50);
            $table->string('full_name', 100);
            $table->string('user_email', 50);
            $table->string('user_mobile', 50);
            $table->text('address');
            $table->integer('package_id');
            $table->string('use_pin')->nullable();
            $table->string('green_pin');
            $table->string('password');
            $table->string('conform_password');
            $table->text('profile_pic');
            $table->string('bitcoin_wallet_address')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->enum('user_status', ['active', 'inactive'])->default('inactive');
            $table->enum('binary_status', ['0', '1']);
            $table->string('status')->nullable();
            $table->string('joining_date');
            $table->string('last_login_date');
            $table->string('currency');
            $table->string('exchange_rate')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
