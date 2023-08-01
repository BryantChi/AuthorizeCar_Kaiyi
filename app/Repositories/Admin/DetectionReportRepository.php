<?php

namespace App\Repositories\Admin;

use App\Models\Admin\DetectionReport as Model;

class DetailReportRepository {


    public static function getAllDetectionReports() {

        $model = Model::all();

        return $model;
    }

}
