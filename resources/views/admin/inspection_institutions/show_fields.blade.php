<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $inspectionInstitution->id }}</p>
</div>

<!-- Ii Name Field -->
<div class="col-sm-12">
    {!! Form::label('ii_name', '檢測機構名稱:') !!}
    <p>{{ $inspectionInstitution->ii_name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $inspectionInstitution->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $inspectionInstitution->updated_at }}</p>
</div>

