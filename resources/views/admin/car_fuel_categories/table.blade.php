<div class="table-responsive p-3">
    <table class="table w-100" id="carFuelCategories-table">
        <thead>
        <tr>
            <th>燃油類別</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($carFuelCategories as $carFuelCategory)
            <tr>
                <td>{{ $carFuelCategory->category_name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.carFuelCategories.destroy', $carFuelCategory->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.carFuelCategories.show', [$carFuelCategory->id]) }}"
                           class='btn btn-default btn-sm'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.carFuelCategories.edit', [$carFuelCategory->id]) }}"
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
