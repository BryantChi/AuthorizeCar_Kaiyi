<!-- Com Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('com_name', '公司名:') !!}
    {!! Form::text('com_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Com Gui Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('com_gui_number', '統一編號:') !!}
    {!! Form::text('com_gui_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Com Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('com_address', '地址:') !!}
    {!! Form::text('com_address', null, ['class' => 'form-control']) !!}
</div>

<!-- Com Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('com_phone', '聯絡電話:') !!}
    {!! Form::text('com_phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Com Fax Field -->
<div class="form-group col-sm-6">
    {!! Form::label('com_fax', '傳真:') !!}
    {!! Form::text('com_fax', null, ['class' => 'form-control']) !!}
</div>

<!-- Com Seal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('com_seal', '公司印章:') !!}
    {{-- {!! Form::file('com_seal', null, ['class' => 'custom-file-input', 'accept' => 'image/*']) !!} --}}
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="com_seal" name="com_seal" accept="image/*">
        <label class="custom-file-label" for="com_seal">Choose file</label>
    </div>
</div>
