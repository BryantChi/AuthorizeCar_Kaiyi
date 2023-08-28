<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignsToDetectionReportsTable extends Migration
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
            $table->unsignedInteger('reports_reporter')->change();

            $table->foreign('reports_reporter')->references('id')->on('reporter_infos');
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
            $table->string('reports_reporter')->change();

            $table->dropForeign(['reports_reporter']);
        });
    }
}
