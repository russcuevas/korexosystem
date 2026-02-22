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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number');
            $table->unsignedBigInteger('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->string('email')->nullable();
            $table->unsignedBigInteger('is_rice_menu')->nullable();
            $table->foreign('is_rice_menu')->references('id')->on('menus')->onDelete('set null');
            $table->unsignedBigInteger('is_add_ons_menu')->nullable();
            $table->foreign('is_add_ons_menu')->references('id')->on('menus')->onDelete('set null');
            $table->boolean('is_served')->default(false);
            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2)->default(0.00);
            $table->string('status')->default('Placed order');
            $table->dateTime('reserved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
