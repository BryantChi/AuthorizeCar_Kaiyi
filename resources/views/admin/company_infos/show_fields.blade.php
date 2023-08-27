<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $companyInfo->id }}</p>
</div>

<!-- Com Name Field -->
<div class="col-sm-12">
    {!! Form::label('com_name', '公司名:') !!}
    <p>{{ $companyInfo->com_name }}</p>
</div>

<!-- Com Gui Number Field -->
<div class="col-sm-12">
    {!! Form::label('com_gui_number', '統一編號:') !!}
    <p>{{ $companyInfo->com_gui_number }}</p>
</div>

<!-- Com Address Field -->
<div class="col-sm-12">
    {!! Form::label('com_address', '公司地址:') !!}
    <p>{{ $companyInfo->com_address }}</p>
</div>

<!-- Com Phone Field -->
<div class="col-sm-12">
    {!! Form::label('com_phone', '聯絡電話:') !!}
    <p>{{ $companyInfo->com_phone }}</p>
</div>

<!-- Com Fax Field -->
<div class="col-sm-12">
    {!! Form::label('com_fax', '傳真:') !!}
    <p>{{ $companyInfo->com_fax }}</p>
</div>

<!-- Com Seal Field -->
<div class="col-sm-12">
    {!! Form::label('com_seal', '公司印章:') !!}
    <p>{{ $companyInfo->com_seal }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $companyInfo->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $companyInfo->updated_at }}</p>
</div>

