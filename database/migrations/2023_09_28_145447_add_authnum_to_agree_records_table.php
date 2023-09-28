<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAuthnumToAgreeRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agree_authorize_records_infos', function (Blueprint $table) {
            //
            $table->string('authorize_num')->after('id')->nullable()->comment('授權證明書編號');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agree_authorize_records_infos', function (Blueprint $table) {
            //
            $table->dropColumn('authorize_num');
        });
    }
}
