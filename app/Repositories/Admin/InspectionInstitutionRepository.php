<?php

namespace App\Repositories\Admin;

use App\Models\Admin\InspectionInstitution;
use App\Repositories\BaseRepository;

/**
 * Class InspectionInstitutionRepository
 * @package App\Repositories\Admin
 * @version August 27, 2023, 3:26 am CST
*/

class InspectionInstitutionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'ii_name'
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
        return InspectionInstitution::class;
    }
}
