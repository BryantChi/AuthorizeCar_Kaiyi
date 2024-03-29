<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class ExportAuthorizeRecords
 * @package App\Models\Admin
 * @version September 24, 2023, 5:15 pm CST
 *
 * @property string $reports_ids
 * @property string $export_authorize_num
 * @property string $export_authorize_com
 * @property string $export_authorize_brand
 * @property integer $export_authorize_model
 * @property string $export_authorize_type_year
 * @property string $export_authorize_vin
 * @property string $export_authorize_date
 * @property string $export_authorize_auth_num_id
 * @property string $export_authorize_reports_nums
 * @property string $export_authorize_path
 * @property string $export_authorize_note
 */
class ExportAuthorizeRecords extends Model
{
    use SoftDeletes;


    public $table = 'export_authorize_records_infos';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'reports_ids',
        'export_authorize_num',
        'export_authorize_com',
        'export_authorize_brand',
        'export_authorize_model',
        'export_authorize_type_year',
        'export_authorize_vin',
        'export_authorize_date',
        'export_authorize_auth_num_id',
        'export_authorize_reports_nums',
        'export_authorize_path',
        'export_authorize_note'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'reports_ids' => 'json',
        'export_authorize_num' => 'string',
        'export_authorize_com' => 'string',
        'export_authorize_brand' => 'string',
        'export_authorize_model' => 'integer',
        'export_authorize_vin' => 'string',
        'export_authorize_date' => 'string',
        'export_authorize_auth_num_id' => 'json',
        'export_authorize_reports_nums' => 'json',
        'export_authorize_path' => 'json',
        'export_authorize_note' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
