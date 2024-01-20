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
        Schema::create('user_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('course_order_id');
            $table->float('amount');
            $table->string('payment_method');
            $table->string('stripe_invoice_id')->nullable();
            $table->string('stripe_invoice_number')->nullable();
            $table->string('stripe_invoice_pdf')->nullable();
            $table->string('stripe_payment_intent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payments');
    }
};
