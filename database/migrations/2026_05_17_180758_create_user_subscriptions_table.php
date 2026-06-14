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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('subscription_plan_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('category_id')->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->string('order_number');

            $table->decimal('total_amount', 10, 2);
            $table->decimal('dis_amount', 10, 2)->default(0);
            $table->decimal('gst_amount', 10, 2)->default(0);
            $table->decimal('final_amount', 10, 2);

            $table->string('payment_method')->nullable(); // razorpay, stripe
            $table->string('razorpay_order_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('signature')->nullable();

            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed',
                'refunded'
            ])->default('pending');

            $table->boolean('status')->default(true);
            $table->datetime('starts_at');
            $table->datetime('expires_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
