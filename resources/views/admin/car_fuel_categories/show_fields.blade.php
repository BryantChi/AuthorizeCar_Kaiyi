<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $carFuelCategory->id }}</p>
</div>

<!-- Category Name Field -->
<div class="col-sm-12">
    {!! Form::label('category_name', '燃油類別:') !!}
    <p>{{ $carFuelCategory->category_name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $carFuelCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $carFuelCategory->updated_at }}</p>
</div>

