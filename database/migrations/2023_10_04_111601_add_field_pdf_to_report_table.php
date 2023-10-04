<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldPdfToReportTable extends Migration
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
            $table->longText('reports_pdf')->after('reports_photos')->nullable()->comment('PDF');
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
            $table->dropColumn('reports_pdf');
        });
    }
}
