<?php

namespace App\Repositories\Admin;

use App\Models\Admin\CarModel;
use App\Repositories\BaseRepository;

/**
 * Class CarModelRepository
 * @package App\Repositories\Admin
 * @version August 1, 2023, 5:15 pm UTC
*/

class CarModelRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'car_brand_id',
        'model_name'
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
        return CarModel::class;
    }
}
