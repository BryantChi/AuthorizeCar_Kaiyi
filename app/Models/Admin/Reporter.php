<?php

namespace App\Models\Admin;

// use Eloquent as Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Reporter
 * @package App\Models\Admin
 * @version July 27, 2023, 9:14 am UTC
 *
 * @property string $reporter_name
 */
class Reporter extends Model
{
    use SoftDeletes;


    public $table = 'reporter_infos';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'reporter_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'reporter_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];


}
