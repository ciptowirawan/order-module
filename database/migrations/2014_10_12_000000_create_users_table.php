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
            $table->string('full_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('registration_type');
            $table->string('title')->nullable();
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('country');
            $table->string('city');
            $table->string('province');
            $table->string('zip');
            $table->string('phone_number');
            $table->string('alternate_phone_number')->nullable();
            $table->string('club_number')->nullable();
            $table->string('club_name')->nullable();
            $table->string('emergency_contact');
            $table->string('emergency_phone_number');
            $table->string('district');
            $table->string('status')->default('PENDING');
            $table->string('registrant_tag')->nullable();
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
