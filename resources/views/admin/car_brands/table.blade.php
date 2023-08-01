<div class="table-responsive">
    <table class="table" id="carBrands-table">
        <thead>
        <tr>
            <th>廠牌名稱</th>
            <th colspan="3">Action</th>
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
                           class='btn btn-default btn-xs'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.carBrands.edit', [$carBrand->id]) }}"
                           class='btn btn-default btn-xs'>
                            <i class="far fa-edit"></i>
                        </a>
                        {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>