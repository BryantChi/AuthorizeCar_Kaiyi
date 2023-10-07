<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class AffidavitRecord
 * @package App\Models\Admin
 * @version October 8, 2023, 4:36 am CST
 *
 * @property string $report_id
 * @property string $affidavit_path
 */
class AffidavitRecord extends Model
{
    use SoftDeletes;


    public $table = 'affidavit_record_infos';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'report_id',
        'affidavit_path'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'report_id' => 'string',
        'affidavit_path' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
