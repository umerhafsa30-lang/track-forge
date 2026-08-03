<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name')->default('cartoys.pk');
            $table->string('whatsapp_number')->default('923000000000');
            $table->unsignedInteger('free_delivery_threshold')->default(2000);
            $table->unsignedInteger('delivery_charge')->default(200);
            $table->string('announcement')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
