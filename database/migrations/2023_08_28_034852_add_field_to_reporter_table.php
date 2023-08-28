<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToReporterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reporter_infos', function (Blueprint $table) {
            //
            $table->string('reporter_gui_number')->after('reporter_name');
            $table->string('reporter_address')->after('reporter_gui_number');
            $table->string('reporter_phone')->after('reporter_address');
            $table->string('reporter_fax')->after('reporter_phone');
            $table->text('reporter_seal')->after('reporter_fax')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reporter_infos', function (Blueprint $table) {
            //
        });
    }
}
