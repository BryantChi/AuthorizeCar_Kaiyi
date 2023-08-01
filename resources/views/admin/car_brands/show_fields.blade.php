<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $carBrand->id }}</p>
</div>

<!-- Brand Name Field -->
<div class="col-sm-12">
    {!! Form::label('brand_name', '廠牌名稱:') !!}
    <p>{{ $carBrand->brand_name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $carBrand->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $carBrand->updated_at }}</p>
</div>

