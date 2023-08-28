<div class="table-responsive">
    <table class="table table-hover" id="detectionReports-table">
        <thead>
            <tr>
                <th>
                    <div class="form-group form-check mb-0 py-1 d-flex align-items-center">
                        <input type="checkbox" class="form-check-input check-all mr-1 my-0"
                            style="width: 20px;height: 20px;" id="check-all" value="" />
                        <label for="check-all" class="check-all-label px-2 mb-0">全選</label>
                    </div>
                </th>
                <th>發函文號</th>
                <th>檢測報告編號</th>
                <th>有效期限-迄</th>
                <th>報告原有人</th>
                <th>廠牌</th>
                <th>車型</th>
                <th>檢測機構</th>
                <th>法規項目</th>
                <th>車種代號</th>
                <th>測試日期</th>
                <th>報告日期</th>
                <th>代表車車身碼</th>
                <th>移入前授權使用次數</th>
                <th>移入後累計授權次數</th>
                <th>F/E</th>
                <th>車安回函</th>
                <th>說明</th>
                <th>授權狀態</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detectionReports as $item)
                <tr>
                    <td>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" style="width: 20px;height: 20px;"
                                name="reports[]" id="{{ $item->id }}" value="{{ $item->id }}"
                                data-reporter="{{ $item->reports_reporter }}" />
                        </div>
                    </td>
                    <td>{{ $item->letter_id }}</td>
                    <td>{{ $item->reports_num }}</td>
                    <td>{{ $item->reports_expiration_date_end }}</td>
                    <td>{{ DB::table('reporter_infos')->whereNull('deleted_at')->where('id', $item->reports_reporter)->value('reporter_name') }}
                    </td>
                    <td>{{ DB::table('car_brand')->whereNull('deleted_at')->where('id', $item->reports_car_brand)->value('brand_name') }}
                    </td>
                    <td>{{ DB::table('car_model')->whereNull('deleted_at')->where('id', $item->reports_car_model)->value('model_name') }}
                    </td>
                    <td>{{ App\Models\Admin\InspectionInstitution::where('id', $item->reports_inspection_institution)->value('ii_name') }}
                    </td>
                    <td class="float-left" style="width: 300px;">
                        <?php
                        $regulations = DB::table('regulations_infos')
                            ->whereNull('deleted_at')
                            ->whereIn('regulations_num', $item->reports_regulations)
                            ->get();
                        ?>
                        @foreach (json_decode($regulations) as $info)
                            <span
                                class="rounded mr-1 my-1 py-1 px-2 bg-info d-flex float-left" style="width: max-content;">{{ $info->regulations_num . ' ' . $info->regulations_name }}</span>
                        @endforeach
                    </td>
                    <td>{{ $item->reports_car_model_code }}</td>
                    <td>{{ $item->reports_test_date }}</td>
                    <td>{{ $item->reports_date }}</td>
                    <td>{{ $item->reports_vin }}</td>
                    <td>{{ $item->reports_authorize_count_before }}</td>
                    <td>{{ $item->reports_authorize_count_current }}</td>
                    <td>{{ $item->reports_f_e }}</td>
                    <td>{{ $item->reports_reply }}</td>
                    <td>{{ $item->reports_note }}</td>
                    <td>{{ DB::table('authorize_status')->whereNull('deleted_at')->where('id', $item->reports_authorize_status)->value('status_name') }}
                    </td>
                    <td width="120">
                        {!! Form::open(['route' => ['admin.detectionReports.destroy', $item->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            {{-- <a href="{{ route('admin.detectionReports.show', [$item->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-eye"></i>
                            </a> --}}
                            <a href="{{ route('admin.detectionReports.edit', [$item->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-edit"></i>
                            </a>
                            {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                'type' => 'button',
                                'class' => 'btn btn-danger btn-sm',
                                'onclick' => 'return check(this)',
                            ]) !!}
                        </div>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@push('page_css')
    <style>
        #detectionReports-table th {
            white-space: nowrap;
        }

        #detectionReports-table td {
            white-space: nowrap;
        }
    </style>
@endpush
@push('page_scripts')
    <script>
        $(function() {
            $('#check-all').change(function() {
                if ($(this).is(':checked')) {
                    $('.check-all-label').html('取消全選');
                    $('#detectionReports-table input[name="reports[]"]').prop('checked', true);
                } else {
                    $('.check-all-label').html('全選');
                    $('#detectionReports-table input[name="reports[]"]').prop('checked', false);
                }
            })
        })
    </script>
@endpush
