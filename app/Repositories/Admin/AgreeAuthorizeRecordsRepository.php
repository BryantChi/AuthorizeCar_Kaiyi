<?php

namespace App\Repositories\Admin;

use App\Models\Admin\AgreeAuthorizeRecords;
use App\Repositories\BaseRepository;

/**
 * Class AgreeAuthorizeRecordsRepository
 * @package App\Repositories\Admin
 * @version September 24, 2023, 2:41 pm CST
*/

class AgreeAuthorizeRecordsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'reports_id',
        'reports_num',
        'authorize_date',
        'authorize_year',
        'car_brand_id',
        'car_model_id',
        'reports_vin',
        'reports_regulations',
        'licensee',
        'Invoice_title'
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
        return AgreeAuthorizeRecords::class;
    }
}
