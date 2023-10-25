<div class="table-responsive2">
    <table class="table table-hover table-striped table-bordered" id="detectionReports-table">
        <thead>
            <tr>
                <th>

                </th>
                <th>檢測報告編號</th>
                <th>發函文號</th>
                <th>授權狀態</th>
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
                <th>Action</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th class="ft-none">

                </th>
                <th><input type="text" class="form-control" placeholder="Search 檢測報告編號"/></th>
                <th><input type="text" class="form-control" placeholder="Search 發函文號"/></th>
                <th>
                    <select class="form-control">
                        <option value="">請選擇 授權狀態</option>
                        @foreach ($auth_status as $status)
                            <option value="{{ $status->status_name }}">{{ $status->status_name }}</option>
                        @endforeach
                    </select>
                </th>
                <th><input type="text" class="form-control" placeholder="Search 有效期限-迄"/></th>
                <th>
                    <select class="form-control">
                        <option value="">請選擇 報告原有人</option>
                        @foreach ($reporters as $reporter)
                            <option value="{{ $reporter->reporter_name }}">{{ $reporter->reporter_name }}</option>
                        @endforeach
                    </select>
                </th>
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
                <th>
                    <select class="form-control">
                        <option value="">請選擇 檢測機構</option>
                        @foreach ($iis as $ii)
                            <option value="{{ $ii->ii_name }}">{{ $m->ii_name }}</option>
                        @endforeach
                    </select>
                </th>
                <th style="max-width: 300px;">法規項目</th>
                <th><input type="text" class="form-control" placeholder="Search 車種代號"/></th>
                <th><input type="text" class="form-control" placeholder="Search 測試日期"/></th>
                <th><input type="text" class="form-control" placeholder="Search 報告日期"/></th>
                <th><input type="text" class="form-control" placeholder="Search 代表車車身碼"/></th>
                <th><input type="text" class="form-control" placeholder="Search 移入前授權使用次數"/></th>
                <th><input type="text" class="form-control" placeholder="Search 移入後累計授權次數"/></th>
                <th>
                    <select class="form-control">
                        <option value="">請選擇 F/E</option>
                        <option value="f">F</option>
                        <option value="e">E</option>
                    </select>
                </th>
                <th><input type="text" class="form-control" placeholder="Search 車安回函"/></th>
                <th><input type="text" class="form-control" placeholder="Search 說明"/></th>
                <th class="ft-none">Action</th>
            </tr>
        </tfoot>
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
{{--  --}}
