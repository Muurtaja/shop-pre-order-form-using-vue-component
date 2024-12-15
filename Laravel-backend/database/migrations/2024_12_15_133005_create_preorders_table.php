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
        Schema::create('preorders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->timestamps();


            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('deleted_by_id')->nullable()->constrained('users')->onDelete('set null');

            $table->index('name');
            $table->index('email');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preorders');
    }
};


