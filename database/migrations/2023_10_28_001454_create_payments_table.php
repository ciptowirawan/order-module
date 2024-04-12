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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', $precision = 12, $scale = 2);
            $table->string('status')->default('unpaid');
            $table->string('payment_evidence')->nullable();
            $table->datetime('payment_date')->nullable();
            $table->decimal('paid_amount', $precision = 12, $scale = 2)->nullable();
            $table->foreignId('pendaftaran_id')->references('id')->on('pendaftaran')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
