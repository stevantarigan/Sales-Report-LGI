<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SalesTransaction;

return new class extends Migration {
    public function up()
    {
        // Update existing status values
        DB::table('sales_transactions')
            ->where('status', 'pending')
            ->update(['status' => 'first_meet']);

        DB::table('sales_transactions')
            ->where('status', 'completed')
            ->update(['status' => 'completed']);

        DB::table('sales_transactions')
            ->where('status', 'cancelled')
            ->update(['status' => 'first_meet']);

        // Update existing payment status values
        DB::table('sales_transactions')
            ->where('payment_status', 'pending')
            ->update(['payment_status' => 'dp']);

        DB::table('sales_transactions')
            ->where('payment_status', 'paid')
            ->update(['payment_status' => 'completed']);

        DB::table('sales_transactions')
            ->where('payment_status', 'cancelled')
            ->update(['payment_status' => 'dp']);
    }

    public function down()
    {
        // Revert changes if needed
        DB::table('sales_transactions')
            ->where('status', 'first_meet')
            ->update(['status' => 'pending']);

        DB::table('sales_transactions')
            ->where('payment_status', 'dp')
            ->update(['payment_status' => 'pending']);
    }
};