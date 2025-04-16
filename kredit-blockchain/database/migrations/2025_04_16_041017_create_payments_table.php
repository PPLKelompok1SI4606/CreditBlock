<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_application_id')->constrained('loan_applications')->onDelete('cascade'); // Tambahkan kolom ini
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Tambahkan kolom user_id
            $table->decimal('amount', 15, 2);
            $table->date('payment_date');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}