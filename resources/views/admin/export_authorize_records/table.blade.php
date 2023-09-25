<div class="table-responsive2">
    <table class="table table-hover table-striped table-bordered" id="exportAuthorizeRecords-table">
        <thead>
            <tr>
                <th></th>
                {{-- <th>檢測報告ID</th> --}}
                <th>授權書編號</th>
                <th>授權公司</th>
                <th>廠牌</th>
                <th>型號</th>
                <th>車身碼</th>
                <th style="width: 20rem !important;">授權使用序號</th>
                <th style="width: 20rem !important;">檢測報告編號</th>
                <th>開立授權文件</th>
                {{-- <th colspan="3">Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($exportAuthorizeRecords as $item)
                <?php
                $reports = App\Models\Admin\DetectionReport::whereIn('id', $item->reports_ids)->get();
                $num = '';
                foreach ($reports as $i => $report) {
                    if ($i == 0) {
                        $num .= '<a href="javascript:void(0)" class="text-secondary" onclick="openReport('.$report->id.');">'.$report->reports_num.'</a>';
                    } else {
                        $num .= ', ' . '<a href="javascript:void(0)" class="text-secondary" onclick="openReport(' . $report->id . ');">' . $report->reports_num . '</a>';
                    }
                }

                $files = '';
                $eapath = $item->export_authorize_path;
                $files .= "<a href='" . url($eapath['word']) . "' download><img src='" . asset('assets/img/word-icon.png') . "'' class='img-fluid mx-2 my-1' width='30' title='" . $eapath['authorize_file_name'] . "' alt=''></a>";
                $files .= "<a href='" . url($eapath['pdf']) . "' download><img src='" . asset('assets/img/pdf-icon.png') . "'' class='img-fluid mx-2 my-1' width='30' title='" . $eapath['authorize_file_name'] . "' alt=''></a>";

                $auth_num_id = '';
                foreach ($item->export_authorize_auth_num_id as $i => $v) {
                    if ($i == 0) {
                        $auth_num_id .= $v;
                    } else {
                        $auth_num_id .= ', '. $v;
                    }
                }
                ?>
                <tr>
                    <td>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" style="width: 20px;height: 20px;"
                                name="records[]" id="{{ $item->id }}" value="{{ $item->id }}"/>
                        </div>
                    </td>
                    {{-- <td>{{ $item->reports_ids }}</td> --}}
                    <td>{{ $item->export_authorize_num }}</td>
                    <td>{{ $item->export_authorize_com }}</td>
                    <td>{{ DB::table('car_brand')->whereNull('deleted_at')->where('id', $item->export_authorize_brand)->value('brand_name') }}
                    </td>
                    <td>{{ DB::table('car_model')->whereNull('deleted_at')->where('id', $item->export_authorize_model)->value('model_name') }}
                    </td>
                    <td>{{ $item->export_authorize_vin }}</td>
                    <td class="w-40-rem" style="max-width: 40rem !important;white-space: normal !important;">{{ $auth_num_id }}</td>
                    <td class="text-bold w-40-rem" style="max-width: 40rem !important;white-space: normal !important;">{!! $num !!}</td>
                    <td>{!! $files !!}</td>
                    {{-- <td width="120">
                        {!! Form::open([
                            'route' => ['admin.exportAuthorizeRecords.destroy', $item->id],
                            'method' => 'delete',
                        ]) !!}
                        <div class='btn-group'>
                            <a href="{{ route('admin.exportAuthorizeRecords.show', [$item->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.exportAuthorizeRecords.edit', [$item->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'button',
                                'class' => 'btn btn-danger btn-sm',
                                'onclick' => "return check(this)",
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="ft-none"></th>
                {{-- <th>檢測報告ID</th> --}}
                <th>授權書編號</th>
                <th>授權公司</th>
                <th>廠牌</th>
                <th>型號</th>
                <th>車身碼</th>
                <th style="width: 20rem !important;">授權使用序號</th>
                <th style="width: 20rem !important;">檢測報告編號</th>
                <th>開立授權文件</th>
                {{-- <th colspan="3">Action</th> --}}
            </tr>
        </tfoot>
    </table>
</div>
@push('page_css')
    <style>
        #exportAuthorizeRecords-table th {
            white-space: nowrap;
        }

        #exportAuthorizeRecords-table td {
            white-space: nowrap;
        }

        .w-40-rem {
            min-width: 15rem !important;
            width: 40rem !important;
        }
    </style>
@endpush
