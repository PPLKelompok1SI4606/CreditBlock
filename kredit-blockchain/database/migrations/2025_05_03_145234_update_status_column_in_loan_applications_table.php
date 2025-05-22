<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class UpdateStatusColumnInLoanApplicationsTable extends Migration
    {
        public function up(): void
        {
            Schema::table('loan_applications', function (Blueprint $table) {
                $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'Belum Lunas', 'Lunas'])
                      ->default('PENDING')
                      ->change();
            });
        }

        public function down(): void
        {
            Schema::table('loan_applications', function (Blueprint $table) {
                $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'Lunas'])
                      ->default('PENDING')
                      ->change();
            });
        }
    }
