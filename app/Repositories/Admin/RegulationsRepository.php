<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Regulations;
use App\Repositories\BaseRepository;

/**
 * Class RegulationsRepository
 * @package App\Repositories\Admin
 * @version July 27, 2023, 6:32 am UTC
*/

class RegulationsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'regulations_num',
        'regulations_name'
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
        return Regulations::class;
    }
}
