<div class="table-responsive2">
    <table class="table table-hover table-striped table-bordered" id="agreeAuthorizeRecords-table">
        <thead>
            <tr>
                <th></th>
                {{-- <th>檢測報告ID</th> --}}
                <th>授權證明書編號</th>
                <th>授權日期</th>
                <th>年份</th>
                <th>廠牌</th>
                <th>車型</th>
                <th>車身碼</th>
                <th style="max-width: 300px;">授權項目</th>
                <th>對象</th>
                <th>發票抬頭</th>
                {{-- <th colspan="3">Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($agreeAuthorizeRecords as $item)
                <tr>
                    <td>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" style="width: 20px;height: 20px;"
                                name="records[]" id="{{ $item->id }}" value="{{ $item->id }}"/>
                        </div>
                        {{-- { "id" : "{{ $item->id }}" } --}}
                    </td>
                    {{-- <td>{{ $agreeAuthorizeRecords->reports_id }}</td> --}}
                    <td>{{ $item->authorize_num }}</td>
                    {{-- <td>{{ $item->reports_num }}</td> --}}
                    <td>{{ $item->authorize_date }}</td>
                    <td>{{ $item->authorize_year }}</td>
                    <td>{{ DB::table('car_brand')->whereNull('deleted_at')->where('id', $item->car_brand_id)->value('brand_name') }}
                    </td>
                    <td>{{ DB::table('car_model')->whereNull('deleted_at')->where('id', $item->car_model_id)->value('model_name') }}
                    </td>
                    <td>{{ $item->reports_vin }}</td>
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
                    <td>{{ $item->licensee }}</td>
                    <td>{{ DB::table('reporter_infos')->whereNull('deleted_at')->where('id', $item->Invoice_title)->value('reporter_name') }}
                    </td>
                    {{-- <td width="120">
                        {!! Form::open([
                            'route' => ['admin.agreeAuthorizeRecords.destroy', $item->id],
                            'method' => 'delete',
                        ]) !!}
                        <div class='btn-group'>
                            <a href="{{ route('admin.agreeAuthorizeRecords.show', [$item->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.agreeAuthorizeRecords.edit', [$item->id]) }}"
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
                <th>授權證明書編號</th>
                <th>授權日期</th>
                <th>年份</th>
                <th>廠牌</th>
                <th>車型</th>
                <th>車身碼</th>
                <th style="max-width: 300px;">授權項目</th>
                <th>對象</th>
                <th>發票抬頭</th>
                {{-- <th colspan="3">Action</th> --}}
            </tr>
        </tfoot>
    </table>
</div>
@push('page_css')
    <style>
        #agreeAuthorizeRecords-table th {
            white-space: nowrap;
        }

        #agreeAuthorizeRecords-table td {
            white-space: nowrap;
        }

        #agreeAuthorizeRecords-table_length label:first-child {
            margin-top: 4px !important;
            padding: 0 !important
        }
    </style>
@endpush
