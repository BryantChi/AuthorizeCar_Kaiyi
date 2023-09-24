<?php

namespace App\Repositories\Admin;

use App\Models\Admin\CumulativeAuthorizedUsageRecords;
use App\Repositories\BaseRepository;

/**
 * Class CumulativeAuthorizedUsageRecordsRepository
 * @package App\Repositories\Admin
 * @version September 24, 2023, 4:27 pm CST
*/

class CumulativeAuthorizedUsageRecordsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'authorization_serial_number',
        'reports_id',
        'reports_num',
        'applicant',
        'reports_vin',
        'quantity',
        'authorization_date'
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
        return CumulativeAuthorizedUsageRecords::class;
    }
}
