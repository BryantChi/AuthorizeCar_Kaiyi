<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyFeildStatusToReportsTable extends Migration
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
            $table->text('reports_authorize_status')->nullable()->comment('授權狀態')->change();
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
        });
    }
}
