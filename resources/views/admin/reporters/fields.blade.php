<!-- Reporter Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reporter_name', '報告原有人名稱:') !!}
    {!! Form::text('reporter_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Reporter Gui Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reporter_gui_number', '統一編號:') !!}
    {!! Form::text('reporter_gui_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Reporter Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reporter_address', '地址:') !!}
    {!! Form::text('reporter_address', null, ['class' => 'form-control']) !!}
</div>

<!-- Reporter Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reporter_phone', '聯絡電話:') !!}
    {!! Form::text('reporter_phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Reporter Fax Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reporter_fax', '傳真:') !!}
    {!! Form::text('reporter_fax', null, ['class' => 'form-control']) !!}
</div>

<!-- Reporter Seal Field -->
<div class="form-group col-sm-6">
    {!! Form::label('reporter_seal', '原有人印章:') !!}

    <div class="custom-file">
        {!! Form::file('reporter_seal', null, ['class' => 'custom-file-input', 'required' => true]) !!}
        {{-- <input type="file" class="custom-file-input" id="reporter_seal" name="reporter_seal" accept="image/*"> --}}
        <label class="custom-file-label" for="reporter_seal">Choose file</label>
    </div>
</div>
