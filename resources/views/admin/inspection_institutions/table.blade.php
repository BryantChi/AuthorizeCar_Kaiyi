<div class="table-responsive">
    <table class="table" id="inspectionInstitutions-table">
        <thead>
        <tr>
            <th>檢測機構名稱</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($inspectionInstitutions as $inspectionInstitution)
            <tr>
                <td>{{ $inspectionInstitution->ii_name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.inspectionInstitutions.destroy', $inspectionInstitution->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.inspectionInstitutions.show', [$inspectionInstitution->id]) }}"
                           class='btn btn-default btn-sm'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.inspectionInstitutions.edit', [$inspectionInstitution->id]) }}"
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
