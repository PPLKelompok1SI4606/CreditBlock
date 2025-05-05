<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalPaymentToLoanApplicationsTable extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('loan_applications', 'total_payment')) {
            Schema::table('loan_applications', function (Blueprint $table) {
                $table->decimal('total_payment', 15, 2)->nullable()->after('interest_rate');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('loan_applications', 'total_payment')) {
            Schema::table('loan_applications', function (Blueprint $table) {
                $table->dropColumn('total_payment');
            });
        }
    }
}
