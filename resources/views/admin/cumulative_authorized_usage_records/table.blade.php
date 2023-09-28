<div class="table-responsive2">
    <table class="table table-hover table-striped table-bordered" id="cumulativeAuthorizedUsageRecords-table">
        <thead>
            <tr>
                <th></th>
                <th>已授權序號</th>
                {{-- <th>檢測報告ID/th> --}}
                <th>授權書編號</th>
                <th>申請者</th>
                <th>車身號碼</th>
                <th>數量</th>
                <th>授權日期</th>
                {{-- <th colspan="3">Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($cumulativeAuthorizedUsageRecords as $item)
                <tr>
                    <td>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" style="width: 20px;height: 20px;"
                                name="records[]" id="{{ $item->id }}" value="{{ $item->id }}"/>
                        </div>
                    </td>
                    <td>{{ $item->authorization_serial_number }}</td>
                    {{-- <td>{{ $item->reports_id }}</td> --}}
                    <td>{{ "TWCAR-$item->authorize_num" }}</td>
                    {{-- <td>{{ $item->reports_num }}</td> --}}
                    {{-- <td>{{ $item->applicant }}</td> --}}
                    <td>{{ DB::table('reporter_infos')->whereNull('deleted_at')->where('id', $item->applicant)->value('reporter_name') }}
                    </td>
                    <td>{{ $item->reports_vin }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->authorization_date }}</td>
                    {{-- <td width="120">
                        {!! Form::open([
                            'route' => ['admin.cumulativeAuthorizedUsageRecords.destroy', $item->id],
                            'method' => 'delete',
                        ]) !!}
                        <div class='btn-group'>
                            <a href="{{ route('admin.cumulativeAuthorizedUsageRecords.show', [$item->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.cumulativeAuthorizedUsageRecords.edit', [$item->id]) }}"
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
                <th>已授權序號</th>
                {{-- <th>檢測報告ID/th> --}}
                <th>授權書編號</th>
                <th>申請者</th>
                <th>車身號碼</th>
                <th>數量</th>
                <th>授權日期</th>
                {{-- <th colspan="3">Action</th> --}}
            </tr>
        </tfoot>
    </table>
</div>
@push('page_css')
    <style>
        #cumulativeAuthorizedUsageRecords-table th {
            white-space: nowrap;
        }

        #cumulativeAuthorizedUsageRecords-table td {
            white-space: nowrap;
        }

        #cumulativeAuthorizedUsageRecords-table_length label:first-child {
            margin-top: 4px !important;
            padding: 0 !important
        }
    </style>
@endpush
