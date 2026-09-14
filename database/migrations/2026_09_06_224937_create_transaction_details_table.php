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
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
            $table->integer('external_product_id'); // ID Produk dari DummyJSON (contoh: 1)
            $table->string('product_title');
            $table->string('sku', 50)->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->integer('quantity');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
