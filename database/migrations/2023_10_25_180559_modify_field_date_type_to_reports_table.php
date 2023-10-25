<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyFieldDateTypeToReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detection_reports', function (Blueprint $table) {
            //
            $table->string('reports_test_date')->change();
            $table->string('reports_date')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detection_reports', function (Blueprint $table) {
            //
            $table->date('reports_test_date')->change();
            $table->date('reports_date')->change();
        });
    }
}
