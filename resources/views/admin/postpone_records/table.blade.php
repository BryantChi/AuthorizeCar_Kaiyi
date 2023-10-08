<div class="table-responsive p-3">
    <table class="table" id="postponeRecords-table">
        <thead>
            <tr>
                <th>Id</th>
                <th>檢測報告編號</th>
                <th>展延文件</th>
                <th>建立日期</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($postponeRecords as $postponeRecord)
                <?php
                $reports = App\Models\Admin\DetectionReport::whereIn('id', $postponeRecord->report_id)->get();
                $num = '';
                foreach ($reports as $i => $report) {
                    if ($i == 0) {
                        $num .= '<a href="javascript:void(0)" class="text-secondary" onclick="openReport(' . $report->id . ');">' . $report->reports_num . '</a>';
                    } else {
                        $num .= ', ' . '<a href="javascript:void(0)" class="text-secondary" onclick="openReport(' . $report->id . ');">' . $report->reports_num . '</a>';
                    }
                }

                $files = '';
                foreach ($postponeRecord->postpone_path as $key => $value) {
                    switch ($key) {
                        case 0:
                            $files .= '<h5>展延合約書</h5>';
                            foreach ($value as $i => $v) {
                                $files .= "<a href='" . url($v['word']) . "' download><img src='" . asset('assets/img/word-icon.png') . "'' class='img-fluid mx-2 my-1' width='30' title='" . $v['postpone_contract_file_name'] . "' alt=''></a>";
                                $files .= "<a href='" . url($v['pdf']) . "' download><img src='" . asset('assets/img/pdf-icon.png') . "'' class='img-fluid mx-2 my-1' width='30' title='" . $v['postpone_contract_file_name'] . "' alt=''></a>";
                            }
                            break;
                        case 1:
                            $files .= "<h5 class='mt-3'>展延函文</h5>";
                            $files .= "<a href='" . url($value['word']) . "' download><img src='" . asset('assets/img/word-icon.png') . "'' class='img-fluid mx-2 my-1' width='30' title='" . $value['postpone_apply_letter_file_name'] . "' alt=''></a>";
                            $files .= "<a href='" . url($value['pdf']) . "' download><img src='" . asset('assets/img/pdf-icon.png') . "'' class='img-fluid mx-2 my-1' width='30' title='" . $value['postpone_apply_letter_file_name'] . "' alt=''></a><br>";
                            break;
                        case 2:
                            $files .= "<h5 class='mt-3'>展延清冊</h5>";
                            $files .= "<a href='" . url($value['excel']) . "' download><img src='" . asset('assets/img/excel-icon.png') . "'' class='img-fluid mx-2 my-1' width='30' title='" . $value['data_postpone_file_name'] . "' alt=''></a>";
                            break;
                    }
                }
                ?>
                <tr>
                    <td>
                        {{ $postponeRecord->id }}
                    </td>
                    <td class="text-bold" style="min-width: 15rem;max-width: 40rem;">
                        {!! $num !!}
                    </td>
                    <td>
                        <button class="btn btn-outline-primary" type="button" data-toggle="collapse" data-target="#collapseExample_{{ $postponeRecord->id }}"
                            aria-expanded="false" aria-controls="collapseExample_{{ $postponeRecord->id }}">
                            查看
                        </button>
                        <div class="collapse mt-3" id="collapseExample_{{ $postponeRecord->id }}">
                            <div class="card card-body" style="min-width: 15rem;">
                                <div class="d-md-inline-block d-table-row">
                                    {!! $files !!}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        {{ Carbon\Carbon::parse($postponeRecord->created_at)->format('Y-m-d H:i:s') }}
                    </td>
                    <td width="120">
                        {!! Form::open(['route' => ['admin.postponeRecords.destroy', $postponeRecord->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            {{-- <a href="{{ route('admin.postponeRecords.show', [$postponeRecord->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.postponeRecords.edit', [$postponeRecord->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-edit"></i>
                            </a> --}}
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
        #postponeRecords-table th:nth-child(3) {
            white-space: nowrap;
        }

        /* #affidavitRecords-table td {
                white-space: nowrap;
            } */
    </style>
@endpush
