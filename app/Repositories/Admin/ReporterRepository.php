<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Reporter;
use App\Repositories\BaseRepository;

/**
 * Class ReporterRepository
 * @package App\Repositories\Admin
 * @version July 27, 2023, 9:14 am UTC
*/

class ReporterRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'reporter_name',
        'reporter_gui_number',
        'reporter_address',
        'reporter_phone',
        'reporter_fax',
        'reporter_seal',
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
        return Reporter::class;
    }
}
