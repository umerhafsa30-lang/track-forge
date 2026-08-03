<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('city');
            $table->string('area');
            $table->string('full_address');
            $table->text('notes')->nullable();
            $table->enum('payment_method', ['cod', 'jazzcash', 'easypaisa'])->default('cod');
            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('delivery_charge')->default(0);
            $table->unsignedInteger('total');
            $table->enum('status', ['New', 'Processing', 'Shipped', 'Delivered', 'Cancelled'])->default('New');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
