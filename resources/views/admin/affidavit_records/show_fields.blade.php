<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $affidavitRecord->id }}</p>
</div>

<!-- Report Id Field -->
<div class="col-sm-12">
    {!! Form::label('report_id', 'Report Id:') !!}
    <p>{{ $affidavitRecord->report_id }}</p>
</div>

<!-- Affidavit Path Field -->
<div class="col-sm-12">
    {!! Form::label('affidavit_path', 'Affidavit Path:') !!}
    <p>{{ $affidavitRecord->affidavit_path }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $affidavitRecord->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $affidavitRecord->updated_at }}</p>
</div>

