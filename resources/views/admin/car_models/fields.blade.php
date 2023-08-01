<!-- Car Brand Id Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('car_brand_id', '廠牌:') !!}
    {!! Form::text('car_brand_id', null, ['class' => 'form-control']) !!}
</div> --}}
<div class="form-group position-relative">
    <label class="font-weight-bold" for="car_brand_id">廠牌</label>
    <select class="form-control custom-select bg-white @error('car_brand_id') is-invalid @enderror"
        name="car_brand_id">
        <option value="">請選擇</option>
        @foreach ($brand as $item)
            <option value="{{ $item->id }}">{{ $item->brand_name }}</option>
        @endforeach
    </select>
</div>

<!-- Model Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('model_name', '型號名稱:') !!}
    {!! Form::text('model_name', null, ['class' => 'form-control']) !!}
</div>
