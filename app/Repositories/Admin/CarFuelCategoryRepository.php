<?php

namespace App\Repositories\Admin;

use App\Models\Admin\CarFuelCategory;
use App\Repositories\BaseRepository;

/**
 * Class CarFuelCategoryRepository
 * @package App\Repositories\Admin
 * @version May 8, 2024, 9:55 pm CST
*/

class CarFuelCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'category_name'
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
        return CarFuelCategory::class;
    }
}
