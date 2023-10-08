<?php

namespace App\Repositories\Admin;

use App\Models\Admin\PostponeRecord;
use App\Repositories\BaseRepository;

/**
 * Class PostponeRecordRepository
 * @package App\Repositories\Admin
 * @version October 9, 2023, 1:30 am CST
*/

class PostponeRecordRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'report_id',
        'postpone_path'
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
        return PostponeRecord::class;
    }
}
