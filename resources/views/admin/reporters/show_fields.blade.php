<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $reporter->id }}</p>
</div>

<!-- Reporter Name Field -->
<div class="col-sm-12">
    {!! Form::label('reporter_name', '報告原有人名稱:') !!}
    <p>{{ $reporter->reporter_name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $reporter->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $reporter->updated_at }}</p>
</div>

