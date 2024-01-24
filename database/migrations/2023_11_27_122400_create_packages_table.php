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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('currency')->default('gbp');
            $table->integer('user_capacity')->nullable();
            $table->integer('unit_amount')->nullable();
            $table->enum('interval', ['day', 'week', 'month', 'year'])->default('month');
            $table->string('feature_one')->nullable();
            $table->string('feature_two')->nullable();
            $table->string('feature_three')->nullable();
            $table->string('feature_four')->nullable();
            $table->string('feature_five')->nullable();
            $table->string('stripe_product_id')->nullable();
            $table->string('stripe_price_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
