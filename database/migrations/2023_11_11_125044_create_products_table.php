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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eshop_id')->constrained('eshops');
            $table->string('name');
            $table->string('ean', 18);
            $table->unsignedBigInteger('product_price_id')->nullable();
            $table->timestamps();
            $table->foreign('product_price_id')->references('id')->on('product_prices');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
