<?php

namespace App\Repositories\Admin;

use App\Models\Admin\ExportAuthorizeRecords;
use App\Repositories\BaseRepository;

/**
 * Class ExportAuthorizeRecordsRepository
 * @package App\Repositories\Admin
 * @version September 24, 2023, 5:15 pm CST
*/

class ExportAuthorizeRecordsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'reports_ids',
        'export_authorize_num',
        'export_authorize_com',
        'export_authorize_brand',
        'export_authorize_model',
        'export_authorize_vin',
        'export_authorize_auth_num_id',
        'export_authorize_reports_nums',
        'export_authorize_path'
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
        return ExportAuthorizeRecords::class;
    }
}
