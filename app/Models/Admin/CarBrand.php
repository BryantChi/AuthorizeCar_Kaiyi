<?php

namespace App\Models\Admin;

// use Eloquent as Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * Class CarBrand
 * @package App\Models\Admin
 * @version August 1, 2023, 9:36 am UTC
 *
 * @property string $brand_name
 */
class CarBrand extends Model
{
    use SoftDeletes;


    public $table = 'car_brand';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'brand_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'brand_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function carModels()
    {
        return $this->hasMany(\App\Models\Admin\CarModel::class);
    }

    // 關聯刪除
    // protected static function booted()
    // {
    //     static::deleting(function ($carBrand) {
    //         $carBrand->carModels()->delete();

    //         $carBrand->detectionReports()->delete();
    //     });
    // }
}
