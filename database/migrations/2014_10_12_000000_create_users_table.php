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
            // $table->string('full_name', 100);
            $table->string('full_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('title')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zip')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('alternate_phone_number')->nullable();
            $table->string('club_number')->nullable();
            $table->string('club_name')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_phone_number')->nullable();
            $table->string('district')->nullable();
            $table->string('terms')->nullable();
            $table->string('conditions')->nullable();
            $table->string('status')->default('PENDING');
            $table->string('registrant_tag')->nullable();
            $table->datetime('member_activate_in')->nullable(); 
            $table->datetime('member_over_in')->nullable();
            $table->string('virtual_account')->nullable();
            $table->rememberToken();
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
