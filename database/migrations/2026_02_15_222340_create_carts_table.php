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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number');

            // The main menu item
            $table->unsignedBigInteger('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->unsignedBigInteger('is_rice_menu')->nullable();
            $table->foreign('is_rice_menu')->references('id')->on('menus')->onDelete('set null');
            $table->unsignedBigInteger('is_add_ons_menu')->nullable();
            $table->foreign('is_add_ons_menu')->references('id')->on('menus')->onDelete('set null');
            $table->string('size')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2)->default(0.00);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
