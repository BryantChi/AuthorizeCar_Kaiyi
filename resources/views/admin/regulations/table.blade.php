<div class="table-responsive">
    <table class="table" id="regulations-table">
        <thead>
            <tr>
                <th>法規編號</th>
                <th>法規名稱</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($regulations as $regulations)
                <tr>
                    <td>{{ $regulations->regulations_num }}</td>
                    <td>{{ $regulations->regulations_name }}</td>
                    <td width="120">
                        {!! Form::open(['route' => ['admin.regulations.destroy', $regulations->id], 'method' => 'delete']) !!}
                        <div class='btn-group'>
                            <a href="{{ route('admin.regulations.show', [$regulations->id]) }}"
                                class='btn btn-default btn-sm'>
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.regulations.edit', [$regulations->id]) }}"
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
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
