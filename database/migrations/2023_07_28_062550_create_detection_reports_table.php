<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetectionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detection_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('letter_id')->nullable()->comment('發函文號');
            $table->string('reports_num')->unique()->comment('檢測報告編號'); //
            $table->string('reports_expiration_date_end')->nullable()->comment('有效期限-迄');
            $table->string('reports_reporter')->nullable()->comment('報告原有人'); // db v
            $table->string('reports_car_brand')->nullable()->comment('廠牌'); // db
            $table->string('reports_car_model')->nullable()->comment('型號'); // db
            $table->string('reports_inspection_institution')->nullable()->comment('檢測機構');
            $table->longText('reports_regulations')->nullable()->comment('法規項目'); // db v
            $table->string('reports_car_model_code')->nullable()->comment('車種代號');
            $table->date('reports_test_date')->nullable()->comment('測試日期');
            $table->date('reports_date')->nullable()->comment('報告日期');
            $table->string('reports_vin')->nullable()->comment('代表車車身碼(VIN)');
            $table->integer('reports_authorize_count_before')->default(0)->comment('移入前授權使用次數');
            $table->integer('reports_authorize_count_current')->default(0)->comment('移入後累計授權次數');
            $table->string('reports_f_e')->nullable()->comment('F/E');
            $table->string('reports_reply')->nullable()->comment('車安回函');
            $table->string('reports_note')->nullable()->comment('說明');
            $table->longText('reports_photos')->nullable()->comment('相關照片');
            $table->text('reports_authorize_status')->nullable()->default('')->comment('授權狀態'); // db
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
        Schema::dropIfExists('detection_reports');
    }
}
