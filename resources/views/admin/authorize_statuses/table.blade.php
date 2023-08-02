<div class="table-responsive">
    <table class="table table-hover" id="authorizeStatuses-table">
        <thead>
            <tr>
                <th>狀態名稱</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authorizeStatuses as $authorizeStatus)
                <tr>
                    <td>{{ $authorizeStatus->status_name }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['admin.authorizeStatuses.destroy', $authorizeStatus->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('admin.authorizeStatuses.show', [$authorizeStatus->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.authorizeStatuses.edit', [$authorizeStatus->id]) }}"
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
