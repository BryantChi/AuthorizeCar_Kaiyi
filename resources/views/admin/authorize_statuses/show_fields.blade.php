<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $authorizeStatus->id }}</p>
</div>

<!-- Status Name Field -->
<div class="col-sm-12">
    {!! Form::label('status_name', 'Status Name:') !!}
    <p>{{ $authorizeStatus->status_name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $authorizeStatus->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $authorizeStatus->updated_at }}</p>
</div>

