<?php

namespace App\Repositories\Admin;

use App\Models\Admin\DeliveryRecord;
use App\Repositories\BaseRepository;

/**
 * Class DeliveryRecordRepository
 * @package App\Repositories\Admin
 * @version September 11, 2023, 12:12 pm CST
*/

class DeliveryRecordRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'report_id',
        'delivery_path'
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
        return DeliveryRecord::class;
    }
}
