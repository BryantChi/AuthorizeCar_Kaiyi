<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetectionReport extends Model
{
    use HasFactory;

    use SoftDeletes;


    public $table = 'detection_reports';


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
        'reports_photo' => 'json',
    ];
}
