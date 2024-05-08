<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Add5FieldToDetectionReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detection_reports', function (Blueprint $table) {
            //
            $table->text('reports_vehicle_pattern')->after('reports_f_e')->nullable()->comment('車輛型式');
            $table->text('reports_vehicle_doors')->after('reports_vehicle_pattern')->nullable()->comment('車輛門數');
            $table->text('reports_vehicle_cylinders')->after('reports_vehicle_doors')->nullable()->comment('車輛汽缸數');
            $table->text('reports_vehicle_seats')->after('reports_vehicle_cylinders')->nullable()->comment('車輛座位數');
            $table->text('reports_vehicle_fuel_category')->after('reports_vehicle_seats')->nullable()->comment('車輛燃料類別');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detection_reports', function (Blueprint $table) {
            //
            $table->dropColumn('reports_vehicle_pattern');
            $table->dropColumn('reports_vehicle_doors');
            $table->dropColumn('reports_vehicle_cylinders');
            $table->dropColumn('reports_vehicle_seats');
            $table->dropColumn('reports_vehicle_fuel_category');
        });
    }
}
