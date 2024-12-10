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
        Schema::create('pins', function (Blueprint $table) {
            $table->id();
            $table->string('pin_no');
            $table->decimal('amount', 8, 2); // Assuming the amount is a decimal number with precision 8 and scale 2
            $table->string('pin_type');
            $table->string('status');
            $table->dateTime('crt_date');
            $table->string('create_by_user');
            $table->integer('receiver_id')->nullable();
            $table->integer('sender_id')->nullable();
            $table->dateTime('t_date')->nullable();
            $table->dateTime('buy_date')->nullable();
            $table->integer('member_id')->nullable();
            $table->timestamps(); // Created_at and updated_at columns
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pins');
    }
};
