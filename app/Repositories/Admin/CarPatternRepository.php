<?php

namespace App\Repositories\Admin;

use App\Models\Admin\CarPattern;
use App\Repositories\BaseRepository;

/**
 * Class CarPatternRepository
 * @package App\Repositories\Admin
 * @version May 8, 2024, 2:24 am CST
*/

class CarPatternRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pattern_name'
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
        return CarPattern::class;
    }
}
