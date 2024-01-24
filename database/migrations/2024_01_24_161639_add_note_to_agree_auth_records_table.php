<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoteToAgreeAuthRecordsTable extends Migration
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
            $table->string('auth_note')->nullable()->after('Invoice_title');
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
            $table->dropColumn('auth_note');
        });
    }
}
