<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class CompanyInfo
 * @package App\Models\Admin
 * @version August 27, 2023, 9:00 pm CST
 *
 * @property string $com_name
 * @property string $com_gui_number
 * @property string $com_address
 * @property string $com_phone
 * @property string $com_fax
 * @property string $com_seal
 */
class CompanyInfo extends Model
{
    use SoftDeletes;


    public $table = 'company_infos';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'com_name',
        'com_gui_number',
        'com_address',
        'com_phone',
        'com_fax',
        'com_seal'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'com_name' => 'string',
        'com_gui_number' => 'string',
        'com_address' => 'string',
        'com_phone' => 'string',
        'com_fax' => 'string',
        'com_seal' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'com_seal' => 'required|image',
    ];


}
