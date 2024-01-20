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
        Schema::create('extend_learnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('title')->nullable();
            $table->text('sub_title')->nullable();
            $table->text('sub_sub_title')->nullable();
            $table->string('footer')->nullable();
            $table->string('do_more_title')->nullable();
            $table->text('do_more_description')->nullable();
            $table->string('learn_more_title')->nullable();
            $table->text('learn_more_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extend_learnings');
    }
};
