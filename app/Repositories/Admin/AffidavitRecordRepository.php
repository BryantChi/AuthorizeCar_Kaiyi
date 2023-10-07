<?php

namespace App\Repositories\Admin;

use App\Models\Admin\AffidavitRecord;
use App\Repositories\BaseRepository;

/**
 * Class AffidavitRecordRepository
 * @package App\Repositories\Admin
 * @version October 8, 2023, 4:36 am CST
*/

class AffidavitRecordRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'report_id',
        'affidavit_path'
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
        return AffidavitRecord::class;
    }
}
