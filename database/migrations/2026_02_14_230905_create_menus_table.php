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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('category_id');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');

            $table->string('menu_pic')->nullable();
            $table->string('menu_name');
            $table->decimal('menu_price', 8, 2);
            $table->text('ingredients')->nullable(); // Add this line

            $table->integer('stock_number');
            $table->string('status')->default('available');
            $table->boolean('is_rice_menu')->default(false);
            $table->boolean('is_add_ons_menu')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
