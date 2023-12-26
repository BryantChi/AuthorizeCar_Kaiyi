<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFleidDateToEpAuthRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('export_authorize_records_infos', function (Blueprint $table) {
            //
            $table->string('export_authorize_date')->nullable()->after('export_authorize_vin')->comment('授權日期');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('export_authorize_records_infos', function (Blueprint $table) {
            //
            $table->dropColumn('export_authorize_date');
        });
    }
}
