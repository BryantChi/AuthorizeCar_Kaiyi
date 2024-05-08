<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class CarFuelCategory
 * @package App\Models\Admin
 * @version May 8, 2024, 9:55 pm CST
 *
 * @property string $category_name
 */
class CarFuelCategory extends EloquentModel
{
    use SoftDeletes;


    public $table = 'car_fuel_category_infos';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'category_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'category_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
