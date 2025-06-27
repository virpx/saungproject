<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
  public function up(): void
  {
    Schema::create('order_items', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('order_id');
      $table->unsignedBigInteger('menu_id')->nullable();
      $table->string('sku');
      $table->string('name');
      $table->decimal('price', 15, 2);
      $table->integer('quantity');
      $table->timestamps();

       // Foreign key untuk order_id yang mengarah ke tabel orders
        $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

        // Foreign key untuk menu_id yang mengarah ke tabel menus
        $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('order_items');
  }
}
