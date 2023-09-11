<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $deliveryRecord->id }}</p>
</div>

<!-- Report Id Field -->
<div class="col-sm-12">
    {!! Form::label('report_id', 'Report Id:') !!}
    <p>{{ $deliveryRecord->report_id }}</p>
</div>

<!-- Delivery Path Field -->
<div class="col-sm-12">
    {!! Form::label('delivery_path', 'Delivery Path:') !!}
    <p>{{ $deliveryRecord->delivery_path }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $deliveryRecord->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $deliveryRecord->updated_at }}</p>
</div>

