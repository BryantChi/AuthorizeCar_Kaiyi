<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $carModel->id }}</p>
</div>

<!-- Car Brand Id Field -->
<div class="col-sm-12">
    {!! Form::label('car_brand_id', '廠牌:') !!}
    <p>{{ $carModel->car_brand_id }}</p>
</div>

<!-- Model Name Field -->
<div class="col-sm-12">
    {!! Form::label('model_name', '型號名稱:') !!}
    <p>{{ $carModel->model_name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $carModel->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $carModel->updated_at }}</p>
</div>

