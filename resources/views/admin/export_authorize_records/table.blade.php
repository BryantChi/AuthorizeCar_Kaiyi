<div class="table-responsive2">
    <table class="table table-hover table-striped table-bordered" id="exportAuthorizeRecords-table">
        <thead>
            <tr>
                <th></th>
                {{-- <th>檢測報告ID</th> --}}
                <th>授權書編號</th>
                <th>授權使用對象</th>
                <th>廠牌</th>
                <th>型號</th>
                <th>車身碼</th>
                <th>授權日期</th>
                <th style="width: 20rem !important;">授權使用序號</th>
                <th style="width: 20rem !important;">檢測報告編號</th>
                <th>開立授權文件</th>
                <th>Action</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th class="ft-none"></th>
                {{-- <th>檢測報告ID</th> --}}
                <th>授權書編號</th>
                <th>授權使用對象</th>
                <th>廠牌</th>
                <th>型號</th>
                {{-- <th>
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
                </th> --}}
                <th>車身碼</th>
                <th>授權日期</th>
                <th style="width: 20rem !important;">授權使用序號</th>
                <th style="width: 20rem !important;">檢測報告編號</th>
                <th class="ft-none">開立授權文件</th>
                <th class="ft-none">Action</th>
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

        #exportAuthorizeRecords-table_length label:first-child {
            margin-top: 4px !important;
            padding: 0 !important
        }

        .w-40-rem {
            min-width: 15rem !important;
            /* width: 40rem !important; */
        }
    </style>
@endpush
