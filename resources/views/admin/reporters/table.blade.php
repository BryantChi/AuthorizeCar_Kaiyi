<div class="table-responsive">
    <table class="table" id="reporters-table">
        <thead>
            <tr>
                <th>報告原有人名稱</th>
                <th>統一編號</th>
                <th>地址</th>
                <th>聯絡電話</th>
                <th>傳真</th>
                <th>報告原有人印章</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reporters as $reporter)
                <tr>
                    <td>{{ $reporter->reporter_name }}</td>
                    <td>{{ $reporter->reporter_gui_number }}</td>
                    <td>{{ $reporter->reporter_address }}</td>
                    <td>{{ $reporter->reporter_phone }}</td>
                    <td>{{ $reporter->reporter_fax }}</td>
                    <td>
                        <img src="{{ ($reporter->reporter_seal ?? '') == '' ? '' : env('APP_URL').'/uploads/'.$reporter->reporter_seal }}" class="img-fluid" width="150" alt="">
                    </td>
                    <td width="120">
                        {!! Form::open(['route' => ['admin.reporters.destroy', $reporter->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('admin.reporters.show', [$reporter->id]) }}" class='btn btn-default btn-sm'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.reporters.edit', [$reporter->id]) }}"
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
