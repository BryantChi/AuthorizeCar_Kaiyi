<div class="table-responsive2">
    <table class="table table-hover table-striped table-bordered" id="agreeAuthorizeRecords-table">
        <thead>
            <tr>
                <th></th>
                {{-- <th>檢測報告ID</th> --}}
                <th>授權證明書編號</th>
                {{-- <th>檢測報告編號</th> --}}
                <th>授權日期</th>
                <th>年份</th>
                <th>廠牌</th>
                <th>車型</th>
                <th>車身碼</th>
                <th style="max-width: 300px;">授權項目</th>
                <th>對象</th>
                <th>發票抬頭</th>
                <th>備註</th>
                {{-- <th colspan="3">Action</th> --}}
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th class="ft-none"></th>
                {{-- <th>檢測報告ID</th> --}}
                <th>授權證明書編號</th>
                {{-- <th>檢測報告編號</th> --}}
                <th>授權日期</th>
                <th>年份</th>
                <th>
                    <select class="form-control">
                        <option value="">請選擇 廠牌</option>
                        @foreach ($brand as $b)
                            <option value="{{ $b->brand_name }}">{{ $b->brand_name }}</option>
                        @endforeach
                    </select>
                </th>
                <th>
                    <select class="form-control">
                        <option value="">請選擇 車型</option>
                        @foreach ($model as $m)
                            <option value="{{ $m->model_name }}">{{ $m->model_name }}</option>
                        @endforeach
                    </select>
                </th>
                <th>車身碼</th>
                <th class="text-white" style="max-width: 300px;">授權項目</th>
                <th>對象</th>
                <th class="text-white">發票抬頭</th>
                <th>備註</th>
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
