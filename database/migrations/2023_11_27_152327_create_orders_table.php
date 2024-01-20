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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('order_number')->nullable();
            $table->decimal('subtotal', 8, 2)->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->decimal('total', 8, 2)->nullable();
            $table->enum('payment_status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->enum('order_status', ['init', 'pending', 'accepted', 'delivered', 'canceled'])->default('init');
            $table->timestamp('order_init_at')->nullable();
            $table->timestamp('order_accepted_at')->nullable();
            $table->timestamp('order_delivered_at')->nullable();
            $table->timestamp('order_canceled_at')->nullable();
            $table->string('transaction_code')->nullable();
            $table->timestamp('transaction_date')->nullable();
            $table->string('currency')->nullable();
            $table->string('stripe_card_id')->nullable();
            $table->string('card_type')->nullable();
            $table->string('card_holder_name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_cvc')->nullable();
            $table->string('card_expiry_month')->nullable();
            $table->string('card_expiry_year')->nullable();
            $table->string('payment_mod')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('stripe_refund_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
