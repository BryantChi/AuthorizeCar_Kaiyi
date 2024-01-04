<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class CumulativeAuthorizedUsageRecords
 * @package App\Models\Admin
 * @version September 24, 2023, 4:27 pm CST
 *
 * @property integer $authorization_serial_number
 * @property integer $reports_id
 * @property string $reports_num
 * @property integer $applicant
 * @property string $reports_vin
 * @property integer $quantity
 * @property string $authorization_date
 * @property string $auth_type_year
 */
class CumulativeAuthorizedUsageRecords extends Model
{
    use SoftDeletes;


    public $table = 'cumulative_authorized_usage_records_infos';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'authorization_serial_number',
        'reports_id',
        'authorize_num',
        'reports_num',
        'applicant',
        'reports_vin',
        'quantity',
        'authorization_date',
        'auth_type_year'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'authorization_serial_number' => 'integer',
        'reports_id' => 'integer',
        'authorize_num' => 'string',
        'reports_num' => 'string',
        'applicant' => 'integer',
        'reports_vin' => 'string',
        'quantity' => 'integer',
        'authorization_date' => 'string',
        'auth_type_year' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
