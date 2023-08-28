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
        'reporter_name',
        'reporter_gui_number',
        'reporter_address',
        'reporter_phone',
        'reporter_fax',
        'reporter_seal',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'reporter_name' => 'string',
        'reporter_gui_number' => 'string',
        'reporter_address' => 'string',
        'reporter_fax' => 'string',
        'reporter_seal' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'reporter_seal' => 'required|image',
    ];

    public static $messages = [
        'reporter_seal.required' => '印章圖片不可空白',
        'reporter_seal.image' => '格式錯誤，必須是圖檔'
    ];

    public static $update_rules = [
        'reporter_seal' => 'image',
    ];

    public static $update_messages = [
        'reporter_seal.image' => '格式錯誤，必須是圖檔'
    ];

    public function detectionReports()
    {   // 擁有DetectionReport Model, DetestionReport的reports_reporter(foreignKey), Reporter的id(localKey)
        return $this->hasMany(\App\Models\Admin\DetectionReport::class, 'reports_reporter', 'id');
    }
}
