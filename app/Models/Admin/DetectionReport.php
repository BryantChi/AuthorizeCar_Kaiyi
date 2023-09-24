<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetectionReport extends Model
{
    use HasFactory;

    use SoftDeletes;


    protected $table = 'detection_reports';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'letter_id',
        'reports_num',
        'reports_expiration_date_end',
        'reports_reporter',
        'reports_car_brand',
        'reports_car_model',
        'reports_inspection_institution',
        'reports_regulations',
        'reports_car_model_code',
        'reports_test_date',
        'reports_date',
        'reports_vin',
        'reports_authorize_count_before',
        'reports_authorize_count_current',
        'reports_f_e',
        'reports_reply',
        'reports_note',
        'reports_photo',
        'reports_authorize_status'
    ];

    protected $casts = [
        'reports_regulations' => 'json',
        'reports_photo' => 'json',
    ];

    // public function carModel() {
    //     return $this->belongsTo(\App\Models\Admin\CarModel::class, 'id', 'reports_car_model');
    // }

    // public function carBrand() {
    //     return $this->belongsTo(\App\Models\Admin\CarBrand::class, 'id', 'reports_car_brand');
    // }

    // public function inspectionInstitution()
    // {
    //     return $this->belongsTo(\App\Models\Admin\InspectionInstitution::class, 'id', 'reports_inspection_institution');
    // }

    public function repoter()
    {   // 屬於Reporter Model, Reporter的id(foreignKey), DetestionReport的reports_reporter(ownerKey)
        return $this->belongsTo(\App\Models\Admin\Reporter::class, 'id', 'reports_reporter');
    }

    // public function regulations()
    // {
    //     return $this->belongsToMany(\App\Models\Admin\Regulations::class, 'regulations_infos', 'id', 'reports_regulations');
    // }

    public function agreeAuthorizeRecords()
    {   // 擁有AgreeAuthorizeRecords Model, AgreeAuthorizeRecords的reports_id(foreignKey), Reporter的id(localKey)
        return $this->hasMany(\App\Models\Admin\AgreeAuthorizeRecords::class, 'reports_id', 'id');
    }

}
