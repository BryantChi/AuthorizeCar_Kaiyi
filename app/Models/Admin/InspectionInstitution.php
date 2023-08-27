<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class InspectionInstitution
 * @package App\Models\Admin
 * @version August 27, 2023, 3:26 am CST
 *
 * @property string $ii_name
 */
class InspectionInstitution extends Model
{
    use SoftDeletes;


    public $table = 'inspection_institution_infos';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'ii_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ii_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function detectionReports()
    {
        return $this->hasMany(\App\Models\Admin\DetectionReport::class);
    }

}
