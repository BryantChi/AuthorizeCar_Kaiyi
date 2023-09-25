<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyFieldDateTypeToUsageRecordsTable extends Migration
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
            $table->string('authorization_date')->change();
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
        });
    }
}
