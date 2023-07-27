<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $regulations->id }}</p>
</div>

<!-- Regulations Num Field -->
<div class="col-sm-12">
    {!! Form::label('regulations_num', '法規編號:') !!}
    <p>{{ $regulations->regulations_num }}</p>
</div>

<!-- Regulations Name Field -->
<div class="col-sm-12">
    {!! Form::label('regulations_name', '法規名稱:') !!}
    <p>{{ $regulations->regulations_name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $regulations->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $regulations->updated_at }}</p>
</div>

