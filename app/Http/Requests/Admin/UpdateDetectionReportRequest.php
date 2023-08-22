<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetectionReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'reports_num' => 'required',
            'reports_expiration_date_end' => 'required',
            'reports_reporter' => 'required',
            'reports_car_brand' => 'required',
            'reports_car_model' => 'required',
            'reports_regulations' => 'required',
            'reports_test_date' => 'required',
            'reports_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'reports_num.required' => '檢測報告編號不可以空白',
            'reports_expiration_date_end' => '有效期限-迄不可以空白',
            'reports_reporter.required' => '報告原有人不可以空白',
            'reports_car_brand.required' => '廠牌不可以空白',
            'reports_car_model.required' => '型號不可以空白',
            'reports_regulations.required' => '法規項目不可以空白',
            'reports_test_date.required' => '測試日期不可以空白',
            'reports_date.required' => '報告日期不可以空白',
        ];
    }
}
