<?php

namespace App\Models\Admin;

// use Eloquent as Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Regulations
 * @package App\Models\Admin
 * @version July 27, 2023, 6:32 am UTC
 *
 * @property string $regulations_num
 * @property string $regulations_name
 */
class Regulations extends Model
{
    use SoftDeletes;


    public $table = 'regulations_infos';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'regulations_num',
        'regulations_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'regulations_num' => 'string',
        'regulations_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];
}
