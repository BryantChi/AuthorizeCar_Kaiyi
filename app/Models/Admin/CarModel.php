<?php

namespace App\Models\Admin;

// use Eloquent as Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * Class CarModel
 * @package App\Models\Admin
 * @version August 1, 2023, 5:15 pm UTC
 *
 * @property \App\Models\Admin\CarBrand $id
 * @property string $car_brand_id
 * @property string $model_name
 */
class CarModel extends Model
{
    use SoftDeletes;


    public $table = 'car_model';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'car_brand_id',
        'model_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'car_brand_id' => 'string',
        'model_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function brand()
    {
        return $this->belongsTo(\App\Models\Admin\CarBrand::class, 'id', 'car_brand_id');
    }
}
