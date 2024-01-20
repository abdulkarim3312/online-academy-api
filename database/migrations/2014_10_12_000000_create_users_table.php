<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Important note: here users will considered as agent
     * Important note: about status
     * approval -> approved
     * stop -> suspended
     * dormancy -> inactive
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('parent_id')->nullable()->comment('Unique id for each user.');
            $table->string('name')->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->comment('Unique email for each user.');
            $table->string('otp')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->text('detailed_address')->nullable();
            $table->enum('situation', ['approval', 'stop', 'dormancy'])->nullable();
            $table->longText('memo')->nullable();
            $table->string('photo')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamp('registered_at')->nullable();
            $table->string('register_by')->nullable()->comment('admin', 'web', 'facebook', 'google', 'app');
            $table->boolean('allow_promotional_mail')->default(false);
            $table->boolean('accept_terms')->default(true);
            $table->string('recipient')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->string('shipping_address')->nullable();
            $table->string('shipping_road_number')->nullable();
            $table->text('shipping_detailed_address')->nullable();
            $table->text('shipping_message')->nullable();
            $table->text('shipping_message_details')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['parent_id', 'deleted_at']);
            $table->unique(['email', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
