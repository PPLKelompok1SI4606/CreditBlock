<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApprovedColumnInCreditRequestsTable extends Migration
{
    public function up()
    {
        Schema::table('credit_requests', function (Blueprint $table) {
            $table->tinyInteger('approved')->default(0)->change(); // Pastikan mendukung 0, 1, 2
        });
    }

    public function down()
    {
        Schema::table('credit_requests', function (Blueprint $table) {
            $table->tinyInteger('approved')->change();
        });
    }
}