<div class="table-responsive" style="overflow: scroll;">
    <table class="table" id="carModels-table">
        <thead>
        <tr>
            <th>廠牌</th>
            <th>型號名稱</th>
            <th colspan="3">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($carModels as $carModel)
            <tr>
                <td>{{ DB::table('car_brand')->where('id', $carModel->car_brand_id)->value('brand_name') }}</td>
                <td>{{ $carModel->model_name }}</td>
                <td width="120">
                    {!! Form::open(['route' => ['admin.carModels.destroy', $carModel->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('admin.carModels.show', [$carModel->id]) }}"
                           class='btn btn-default btn-sm'>
                            <i class="far fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.carModels.edit', [$carModel->id]) }}"
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
