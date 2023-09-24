<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreeAuthorizeRecordsInfosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agree_authorize_records_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('reports_id');
            $table->string('reports_num');
            $table->string('authorize_date');
            $table->string('authorize_year');
            $table->unsignedInteger('car_brand_id');
            $table->unsignedInteger('car_model_id');
            $table->string('reports_vin');
            $table->text('reports_regulations');
            $table->string('licensee');
            $table->string('Invoice_title');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('reports_id')->references('id')->on('detection_reports');
            $table->foreign('car_brand_id')->references('id')->on('car_brand');
            $table->foreign('car_model_id')->references('id')->on('car_model');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('agree_authorize_records_infos');
    }
}
