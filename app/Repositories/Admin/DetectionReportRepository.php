<?php

namespace App\Repositories\Admin;

use App\Models\Admin\DetectionReport as Model;

class DetectionReportRepository {


    public static function getAllDetectionReports() {

        $model = Model::all();

        return $model;
    }

}
