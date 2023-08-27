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
        Schema::table('repoter_infos', function (Blueprint $table) {
            //
            $table->string('repoter_gui_number')->after('reporter_name');
            $table->string('repoter_address')->after('repoter_gui_number');
            $table->string('repoter_phone')->after('repoter_address');
            $table->string('repoter_fax')->after('reporter_phone');
            $table->text('repoter_seal')->after('repoter_fax')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repoter_infos', function (Blueprint $table) {
            //
        });
    }
}
