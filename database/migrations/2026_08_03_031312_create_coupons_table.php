<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_coupons_table.php
public function up(): void
{
    Schema::create('coupons', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique();
        $table->enum('type', ['fixed', 'percentage'])->default('percentage');
        $table->decimal('value', 10, 2); // 10 (%) ya 500 (Rs fixed)
        $table->decimal('min_order_amount', 10, 2)->nullable(); // minimum cart total
        $table->decimal('max_discount_amount', 10, 2)->nullable(); // percentage type ke liye cap
        $table->integer('usage_limit')->nullable(); // total kitni baar use ho sakta hai
        $table->integer('used_count')->default(0);
        $table->integer('usage_limit_per_user')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamp('starts_at')->nullable();
        $table->timestamp('expires_at')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
