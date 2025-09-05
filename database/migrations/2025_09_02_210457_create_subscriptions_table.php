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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('stripe_session_id')->unique();
            $table->string('stripe_subscription_id')->unique();
            $table->string('stripe_price_id');
            $table->string('plan_id'); // price_id de Stripe o identificador de plan
            $table->string('interval'); // monthly / annual
            $table->integer('amount');
            $table->string('payment_status');
            $table->timestamp('ends_at')->nullable(); // fecha de finalización
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
