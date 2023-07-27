<?php

namespace App\Repositories\Admin;

use App\Models\Admin\AuthorizeStatus;
use App\Repositories\BaseRepository;

/**
 * Class AuthorizeStatusRepository
 * @package App\Repositories\Admin
 * @version July 20, 2023, 10:01 am UTC
*/

class AuthorizeStatusRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'status_name'
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
        return AuthorizeStatus::class;
    }
}
