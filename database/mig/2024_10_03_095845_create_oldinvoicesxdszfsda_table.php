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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->unsigned();
            $table->string('invoiceId');
            $table->date('invoice_date');      
            $table->text('subject')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('total_amount', 10, 0);
            $table->integer('discount_rate')->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('discount_amount', 10, 0)->nullable();
            $table->decimal('igst', 10, 0)->nullable();
            $table->decimal('cgst', 10, 0)->nullable();
            $table->decimal('sgst', 10, 0)->nullable();
            $table->decimal('adjustment', 10, 0)->nullable();
            $table->text('customer_notes')->nullable();
            $table->text('file')->nullable();
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->tinyInteger('is_fixed')->default(0);
            $table->decimal('service_tax', 10, 0)->nullable();

            $table->foreign('customer_id')->references('id')->on('customers')
                ->onUpdate('cascade')->onDelete('cascade');
  
            $table->softDeletes();
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
