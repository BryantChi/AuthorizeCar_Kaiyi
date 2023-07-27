<?php

namespace App\Models\Admin;

use Eloquent as Model;



/**
 * Class AuthorizeStatus
 * @package App\Models\Admin
 * @version July 20, 2023, 10:01 am UTC
 *
 * @property string $status_name
 */
class AuthorizeStatus extends Model
{


    public $table = 'authorize_status';
    



    public $fillable = [
        'status_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'status_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
