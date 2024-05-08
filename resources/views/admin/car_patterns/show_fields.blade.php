<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $carPattern->id }}</p>
</div>

<!-- Pattern Name Field -->
<div class="col-sm-12">
    {!! Form::label('pattern_name', '型式:') !!}
    <p>{{ $carPattern->pattern_name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $carPattern->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $carPattern->updated_at }}</p>
</div>

