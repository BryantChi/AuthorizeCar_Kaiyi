<div class="table-responsive">
    <table class="table table-hover" id="detectionReports-table">
        <thead>
            <tr>
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
                    <td>{{ $item->reports_num }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['admin.detectionReports.destroy', $item->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('admin.detectionReports.show', [$item->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-eye"></i>
                            </a>
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
<style>
    #detectionReports-table th {
        white-space: nowrap;
    }
</style>
