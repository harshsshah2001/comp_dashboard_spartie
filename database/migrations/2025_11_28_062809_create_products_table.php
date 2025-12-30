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
            $table->string('category');
            $table->string('productname');
            $table->string('image')->nullable();
            // i have add New badge column added using a migration
            $table->string('icon')->nullable();
            $table->string('multipleimage')->nullable();
            $table->text('productdescription')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('saleprice', 10, 2)->nullable();
            $table->timestamps();
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
