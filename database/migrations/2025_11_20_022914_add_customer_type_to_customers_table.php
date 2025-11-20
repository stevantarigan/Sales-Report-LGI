<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_customer_type_to_customers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->enum('customer_type', ['KONTRAKTOR', 'ARSITEK', 'TUKANG', 'OWNER', 'UNDEFINED'])
                ->default('UNDEFINED')
                ->after('is_active');
            $table->string('phone_secondary')->nullable()->after('phone');
            $table->text('address')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('province')->nullable()->change();
            $table->string('postal_code')->nullable()->after('province');
            $table->string('country')->default('Indonesia')->after('postal_code');
            $table->string('company')->nullable()->after('country');
            $table->text('notes')->nullable()->after('company');
        });
    }

    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'customer_type',
                'phone_secondary',
                'postal_code',
                'country',
                'company',
                'notes'
            ]);
        });
    }
};