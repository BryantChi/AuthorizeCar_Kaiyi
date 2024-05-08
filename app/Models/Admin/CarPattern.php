<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class CarPattern
 * @package App\Models\Admin
 * @version May 8, 2024, 2:24 am CST
 *
 * @property string $pattern_name
 */
class CarPattern extends EloquentModel
{
    use SoftDeletes;


    public $table = 'car_pattern_infos';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'pattern_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'pattern_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
