<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('sell_price', 10, 2);
            $table->integer('stock')->default(0);
            $table->timestamps();
        });

        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('vat', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->decimal('paid', 10, 2)->default(0);
            $table->decimal('due', 10, 2)->default(0);
            $table->date('date');
            $table->timestamps();
        });

        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('total', 10, 2);
            $table->date('date');
            $table->timestamps();
        });

        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->string('account');
            $table->decimal('debit', 10, 2)->default(0);
            $table->decimal('credit', 10, 2)->default(0);
            $table->date('date');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('products');
    }
};
