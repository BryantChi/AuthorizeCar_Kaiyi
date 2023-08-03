<!-- Regulations Num Field -->
<div class="form-group col-sm-6">
    {!! Form::label('regulations_num', '法規編號:') !!}
    {!! Form::text('regulations_num', null, ['class' => 'form-control']) !!}
    {{-- <input name="regulations_num" id="regulations_num" type="text" class="form-control bg-white @error('regulations_num') is-invalid @enderror"
        required value="{{ $regulations->regulations_num ?? '' }}"> --}}
</div>

<!-- Regulations Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('regulations_name', '法規名稱:') !!}
    {!! Form::text('regulations_name', null, ['class' => 'form-control']) !!}
</div>
