<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $postponeRecord->id }}</p>
</div>

<!-- Report Id Field -->
<div class="col-sm-12">
    {!! Form::label('report_id', 'Report Id:') !!}
    <p>{{ $postponeRecord->report_id }}</p>
</div>

<!-- Postpone Path Field -->
<div class="col-sm-12">
    {!! Form::label('postpone_path', 'Postpone Path:') !!}
    <p>{{ $postponeRecord->postpone_path }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $postponeRecord->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $postponeRecord->updated_at }}</p>
</div>

