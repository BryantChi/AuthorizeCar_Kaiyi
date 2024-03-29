<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class AgreeAuthorizeRecords
 * @package App\Models\Admin
 * @version September 24, 2023, 2:41 pm CST
 *
 * @property integer $reports_id
 * @property string $reports_num
 * @property string $authorize_date
 * @property string $authorize_year
 * @property string $auth_type_year
 * @property integer $car_brand_id
 * @property integer $car_model_id
 * @property string $reports_vin
 * @property string $reports_regulations
 * @property string $licensee
 * @property string $Invoice_title
 * @property string $auth_note
 */
class AgreeAuthorizeRecords extends Model
{
    use SoftDeletes;


    public $table = 'agree_authorize_records_infos';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'reports_id',
        'authorize_num',
        'reports_num',
        'authorize_date',
        'authorize_year',
        'auth_type_year',
        'car_brand_id',
        'car_model_id',
        'reports_vin',
        'reports_regulations',
        'licensee',
        'Invoice_title',
        'auth_note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'authorize_num' => 'string',
        'reports_id' => 'integer',
        'reports_num' => 'string',
        'authorize_date' => 'string',
        'authorize_year' => 'string',
        'auth_type_year' => 'string',
        'car_brand_id' => 'integer',
        'car_model_id' => 'integer',
        'reports_vin' => 'string',
        'reports_regulations' => 'json',
        'licensee' => 'string',
        'Invoice_title' => 'string',
        'auth_note' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function detectionReports()
    {   // 屬於DetectionReport Model, DetectionReport的id(foreignKey), AgreeAuthorizeRecords的reports_id(ownerKey)
        return $this->belongsTo(\App\Models\Admin\DetectionReport::class, 'id', 'reports_id');
    }

}
