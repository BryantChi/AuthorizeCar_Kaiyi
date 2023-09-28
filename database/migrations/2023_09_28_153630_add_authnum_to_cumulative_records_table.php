<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthnumToCumulativeRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cumulative_authorized_usage_records_infos', function (Blueprint $table) {
            //
            $table->string('authorize_num')->after('reports_id')->nullable()->comment('授權書編號');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cumulative_authorized_usage_records_infos', function (Blueprint $table) {
            //
            $table->dropColumn('authorize_num');
        });
    }
}
