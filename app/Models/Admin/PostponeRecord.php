<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class PostponeRecord
 * @package App\Models\Admin
 * @version October 9, 2023, 1:30 am CST
 *
 * @property string $report_id
 * @property string $postpone_path
 */
class PostponeRecord extends Model
{
    use SoftDeletes;


    public $table = 'postpone_record_infos';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'report_id',
        'postpone_path'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'report_id' => 'json',
        'postpone_path' => 'json'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
