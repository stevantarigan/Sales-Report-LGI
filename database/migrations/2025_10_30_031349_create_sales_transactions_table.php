<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Sales
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');

            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('total_price', 12, 2);
            $table->string('payment_status')->default('pending'); // pending, paid, cancelled
            $table->string('photo')->nullable(); // bukti transaksi
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('map_link')->nullable();
            $table->string('status')->default('deal'); // deal, pending, cancel
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_transactions');
    }
};
