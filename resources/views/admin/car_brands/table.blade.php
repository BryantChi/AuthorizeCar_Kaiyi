<div class="table-responsive p-3">
    <table class="table" id="carBrands-table">
        <thead>
        <tr>
            <th>廠牌名稱</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($carBrands as $carBrand)
            <tr>
                <td>{{ $carBrand->brand_name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.carBrands.destroy', $carBrand->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.carBrands.show', [$carBrand->id]) }}"
                           class='btn btn-default btn-sm'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.carBrands.edit', [$carBrand->id]) }}"
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
