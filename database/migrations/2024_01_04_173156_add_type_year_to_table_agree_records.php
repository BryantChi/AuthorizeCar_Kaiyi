<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeYearToTableAgreeRecords extends Migration
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
            $table->string('auth_type_year')->after('authorize_year')->nullable()->comment('樣式年份');
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
            $table->dropColumn('auth_type_year');
        });
    }
}
