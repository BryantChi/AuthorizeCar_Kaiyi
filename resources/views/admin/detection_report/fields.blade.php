{{-- @csrf --}}
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('letter_id', '發函文號') !!}
        {!! Form::text('letter_id', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('reports_num', '檢測報告編號') !!}
        {!! Form::text('reports_num', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('reports_expiration_date_end', '有效期限-迄') !!}
        {!! Form::text('reports_expiration_date_end', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="reports_reporter">報告原有人</label>
        <select class="form-control custom-select bg-white @error('reports_reporter') is-invalid @enderror"
            name="reports_reporter" id="reports_reporter">
            <option value="">請選擇</option>
            @foreach ($reporter as $item)
                <option value="{{ $item->id }}">{{ $item->reporter_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="reports_car_brand">廠牌</label>
        <select class="form-control custom-select bg-white @error('reports_car_brand') is-invalid @enderror"
            name="reports_car_brand" id="reports_car_brand">
            <option value="">請選擇</option>
            @foreach ($brand as $item)
                <option value="{{ $item->id }}">{{ $item->brand_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="reports_car_model">型號</label>
        <select class="form-control custom-select2 bg-white2 @error('reports_car_model') is-invalid @enderror"
            name="reports_car_model" id="reports_car_model">
            <option value="">請選擇</option>
        </select>
    </div>
    <div class="form-group">
        {!! Form::label('reports_inspection_institution', '檢測機構') !!}
        {!! Form::text('reports_inspection_institution', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="reports_regulations">法規項目</label>
        <select class="form-control custom-select bg-white @error('reports_regulations') is-invalid @enderror"
            name="reports_regulations" id="reports_regulations">
            <option value="">請選擇</option>
            @foreach ($regulations as $item)
                <option value="{{ $item->regulations_num }}">{{ $item->regulations_name }}</option>
            @endforeach
        </select>
    </div>

</div>
<div class="col-md-6">
    <div class="form-group">
        {!! Form::label('reports_car_model_code', '車種代號') !!}
        {!! Form::text('reports_car_model_code', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('reports_test_date', '測試日期') !!}
        {!! Form::text('reports_test_date', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('reports_date', '報告日期') !!}
        {!! Form::text('reports_date', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('reports_vin', '代表車車身碼(VIN)') !!}
        {!! Form::text('reports_vin', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group position-relative">
        <label class="font-weight-bold" for="reports_f_e">F/E</label>
        <select class="form-control custom-select bg-white @error('reports_f_e') is-invalid @enderror"
            name="reports_f_e" id="reports_f_e">
            <option value="F">F</option>
            <option value="E">E</option>
        </select>
    </div>
    <div class="form-group">
        {!! Form::label('reports_reply', '車安回函') !!}
        {!! Form::text('reports_reply', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group d-none">
        {!! Form::label('reports_note', '說明') !!}
        {!! Form::text('reports_note', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="reports_authorize_status">授權狀態</label>
        <select class="form-control custom-select bg-white @error('reports_authorize_status') is-invalid @enderror"
            name="reports_authorize_status" id="reports_authorize_status">
            <option value="">請選擇</option>
            @foreach ($authStatus as $item)
                <option value="{{ $item->id }}">{{ $item->status_name }}</option>
            @endforeach
        </select>
    </div>
</div>
@push('scripts')
    <script>
        $('#reports_car_model').empty().select2({
            data: [],
            placeholder: '請先選擇廠牌',
            allowClear: true
        });
        $('#reports_car_brand').on('change', function() {
            var brand_id = $(this).val();
            if (brand_id) {
                $.ajax({
                    url: "{{ route('getModelsByBrand') }}",
                    type: 'GET',
                    data: {
                        brand_id: brand_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(data) {
                        // $('#reports_car_model').empty().select2({
                        //     data: data.map(item => ({
                        //         id: item.id,
                        //         text: item.model_name
                        //     })),
                        //     placeholder: '請先選擇廠牌',
                        //     allowClear: true
                        // });
                        $('#reports_car_model').empty();
                        $('#reports_car_model').append('<option value="">請先選擇廠牌</option>');
                        $.each(data, function(key, value) {
                            $('#reports_car_model').append('<option value="' + value.id + '">' + value
                                .model_name + '</option>');
                        });
                    }
                });
            } else {
                // $('#reports_car_model').empty().select2({
                //     data: [],
                //     placeholder: '請先選擇廠牌',
                //     allowClear: true
                // });
                $('#reports_car_model').empty();
                $('#reports_car_model').append('<option value="">請先選擇廠牌</option>');
            }
        });
    </script>
@endpush
