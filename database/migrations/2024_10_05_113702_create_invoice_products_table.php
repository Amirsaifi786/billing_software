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
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('invoice_id'); // Foreign key to invoice table
            $table->string('name'); // Product name (if not using a separate products table)
            $table->decimal('price', 10, 2); // Product price
            $table->integer('stock'); // Quantity or stock for the product
            $table->decimal('tax', 5, 2); // Tax percentage (5%, 12%, etc.)
            $table->decimal('total', 10, 2); // Total for that line item
            $table->softDeletes();
            $table->timestamps(); // Timestamps for created_at and updated_at

            // Foreign key constraint linking to invoices table
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_products');
    }
};
