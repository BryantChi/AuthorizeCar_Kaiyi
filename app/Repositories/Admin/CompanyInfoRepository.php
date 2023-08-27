<?php

namespace App\Repositories\Admin;

use App\Models\Admin\CompanyInfo;
use App\Repositories\BaseRepository;

/**
 * Class CompanyInfoRepository
 * @package App\Repositories\Admin
 * @version August 27, 2023, 9:00 pm CST
*/

class CompanyInfoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'com_name',
        'com_gui_number',
        'com_address',
        'com_phone',
        'com_fax',
        'com_seal'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CompanyInfo::class;
    }
}
