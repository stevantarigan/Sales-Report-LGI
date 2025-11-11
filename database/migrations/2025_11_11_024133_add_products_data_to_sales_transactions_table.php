<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sales_transactions', function (Blueprint $table) {
            $table->json('products_data')->nullable()->after('total_price');
        });
    }

    public function down()
    {
        Schema::table('sales_transactions', function (Blueprint $table) {
            $table->dropColumn('products_data');
        });
    }
};