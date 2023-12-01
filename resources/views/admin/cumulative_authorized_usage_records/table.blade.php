<div class="table-responsive2">
    <table class="table table-hover table-striped table-bordered" id="cumulativeAuthorizedUsageRecords-table">
        <thead>
            <tr>
                <th></th>
                <th>Id</th>
                <th>已授權序號</th>
                <th>授權書編號</th>
                <th>檢測報告編號</th>
                <th>申請者</th>
                <th>車身號碼</th>
                <th>數量</th>
                <th>授權日期</th>
                <th>Action</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th class="ft-none"></th>
                <th class="ft-none">Id</th>
                <th class="ft-none text-white">已授權序號</th>
                <th>授權書編號</th>
                <th>檢測報告編號</th>
                <th>
                    <select class="form-control">
                        <option value="">請選擇 申請者</option>
                        @foreach ($reporters as $reporter)
                            <option value="{{ $reporter->reporter_name }}">{{ $reporter->reporter_name }}</option>
                        @endforeach
                    </select>
                </th>
                <th>車身號碼</th>
                <th>
                    <select class="form-control">
                        <option value="">請選擇 數量</option>
                        <option value="1">1</option>
                        <option value="0">0</option>
                    </select>
                </th>
                <th>授權日期</th>
                <th class="ft-none"></th>
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
