<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCumulativeAuthorizedUsageRecordsInfosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cumulative_authorized_usage_records_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('authorization_serial_number');
            $table->unsignedInteger('reports_id');
            $table->string('reports_num');
            $table->unsignedInteger('applicant');
            $table->string('reports_vin');
            $table->integer('quantity');
            $table->date('authorization_date');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('reports_id')->references('id')->on('detection_reports');
            $table->foreign('applicant')->references('id')->on('reporter_infos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cumulative_authorized_usage_records_infos');
    }
}
