<div class="table-responsive">
    <table class="table" id="reporters-table">
        <thead>
        <tr>
            <th>報告原有人名稱</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($reporters as $reporter)
            <tr>
                <td>{{ $reporter->reporter_name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.reporters.destroy', $reporter->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.reporters.show', [$reporter->id]) }}"
                           class='btn btn-default btn-sm'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.reporters.edit', [$reporter->id]) }}"
                           class='btn btn-default btn-sm'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'button', 'class' => 'btn btn-danger btn-sm', 'onclick' => "return check(this)"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
