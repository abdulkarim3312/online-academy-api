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
        Schema::create('course_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('package_id');
            $table->string('price_type');
            $table->float('amount')->default(0);
            $table->string('stripe_price_id')->nullable();
            $table->string('stripe_session_id')->nullable();
            $table->string('stripe_subscription_id')->nullable();
            $table->timestamp('next_billing_date')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamp('resumed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_orders');
    }
};
