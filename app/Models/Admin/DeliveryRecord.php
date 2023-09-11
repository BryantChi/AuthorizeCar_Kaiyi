<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class DeliveryRecord
 * @package App\Models\Admin
 * @version September 11, 2023, 12:12 pm CST
 *
 * @property string $report_id
 * @property string $delivery_path
 */
class DeliveryRecord extends Model
{
    use SoftDeletes;


    public $table = 'delivery_record_infos';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'report_id',
        'delivery_path'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'report_id' => 'json',
        'delivery_path' => 'json',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
