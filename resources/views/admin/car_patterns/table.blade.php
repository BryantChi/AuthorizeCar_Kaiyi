<div class="table-responsive p-3">
    <table class="table w-100" id="carPatterns-table">
        <thead>
        <tr>
            <th>樣式</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($carPatterns as $carPattern)
            <tr>
                <td>{{ $carPattern->pattern_name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.carPatterns.destroy', $carPattern->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.carPatterns.show', [$carPattern->id]) }}"
                           class='btn btn-default btn-sm'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.carPatterns.edit', [$carPattern->id]) }}"
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
