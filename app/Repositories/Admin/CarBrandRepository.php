<?php

namespace App\Repositories\Admin;

use App\Models\Admin\CarBrand;
use App\Repositories\BaseRepository;

/**
 * Class CarBrandRepository
 * @package App\Repositories\Admin
 * @version August 1, 2023, 9:36 am UTC
*/

class CarBrandRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'brand_name'
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
        return CarBrand::class;
    }
}
