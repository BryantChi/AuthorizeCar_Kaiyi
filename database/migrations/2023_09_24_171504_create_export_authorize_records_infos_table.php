<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExportAuthorizeRecordsInfosTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_authorize_records_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('reports_ids');
            $table->string('export_authorize_num');
            $table->string('export_authorize_com');
            $table->integer('export_authorize_brand');
            $table->integer('export_authorize_model');
            $table->string('export_authorize_vin');
            $table->longText('export_authorize_auth_num_id');
            $table->longText('export_authorize_reports_nums');
            $table->longText('export_authorize_path');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('export_authorize_records_infos');
    }
}
