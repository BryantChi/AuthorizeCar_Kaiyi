{{-- @csrf --}}
<div class="col-md-6">
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp = session('form_data')['letter_id'] ?? '';
        } else {
            $temp = null;
        }
        ?>
        {!! Form::label('letter_id', '發函文號') !!}
        {!! Form::text('letter_id', $temp, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp2 = session('form_data')['reports_num'] ?? '';
        } else {
            $temp2 = null;
        }
        ?>
        {!! Form::label('reports_num', '檢測報告編號') !!}
        {!! Form::text('reports_num', $temp2, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp3 = session('form_data')['reports_expiration_date_end'] ?? '';
        } else {
            $temp3 = '2053-12-31';
        }
        ?>
        {!! Form::label('reports_expiration_date_end', '有效期限-迄') !!}
        {!! Form::date('reports_expiration_date_end', $temp3, ['class' => 'form-control', 'min' => "0001-01-01", 'max' => "9999-12-31"]) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            if (session('form_data')['reports_reporter'] == null) {
                $temp4 = '';
            } else {
                $temp4 = session('form_data')['reports_reporter'];
            }
        } else {
            $temp4 = '';
        }
        ?>
        <label class="font-weight-bold" for="reports_reporter">報告原有人</label>
        <select class="form-control custom-select bg-white @error('reports_reporter') is-invalid @enderror"
            name="reports_reporter" id="reports_reporter">
            <option value="">請選擇</option>
            @foreach ($reporter as $item)
                <option {{ ($detectionReport->reports_reporter ?? '') == $item->id ? ' selected="selected"' : '' }}
                    {{ $temp4 == $item->id ? ' selected="selected"' : '' }} value="{{ $item->id }}">
                    {{ $item->reporter_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            if (session('form_data')['reports_car_brand'] == null) {
                $temp5 = '';
            } else {
                $temp5 = session('form_data')['reports_car_brand'];
            }
        } else {
            $temp5 = '';
        }
        ?>
        <label class="font-weight-bold" for="reports_car_brand">廠牌</label>
        <select class="form-control custom-select bg-white @error('reports_car_brand') is-invalid @enderror"
            name="reports_car_brand" id="reports_car_brand">
            <option value="">請選擇</option>
            @foreach ($brand as $item)
                <option {{ ($detectionReport->reports_car_brand ?? '') == $item->id ? ' selected="selected"' : '' }}
                    {{ $temp5 == $item->id ? ' selected="selected"' : '' }}
                    value="{{ $item->id }}">{{ $item->brand_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="font-weight-bold" for="reports_car_model">型號</label>
        <select class="form-control custom-select2 bg-white2 w-100 @error('reports_car_model') is-invalid @enderror"
            name="reports_car_model" id="reports_car_model">
            <option value="">請選擇</option>
        </select>
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp6 = session('form_data')['reports_inspection_institution'] ?? '';
        } else {
            $temp6 = $detectionReport->reports_inspection_institution ?? '';
        }
        ?>
        {!! Form::label('reports_inspection_institution', '檢測機構') !!}
        {!! Form::select(
            'reports_inspection_institution',
            $inspectionInstitution,
            $temp6,
            ['class' => 'form-control'],
        ) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp_reg = session('form_data')['reports_regulations'] ?? [];
        } else {
            $temp_reg = [];
        }
        ?>
        <label class="font-weight-bold" for="reports_regulations">法規項目</label>
        <select class="form-control custom-select bg-white @error('reports_regulations') is-invalid @enderror"
            name="reports_regulations[]" id="reports_regulations" multiple="multiple" placeholder="請選擇">
            <option value="">請選擇</option>
            @foreach ($regulations as $item)
                <option
                    {{ in_array($item->regulations_num, $detectionReport->reports_regulations ?? []) ? ' selected="selected"' : '' }}
                    {{ in_array($item->regulations_num, $temp_reg) ? ' selected="selected"' : '' }}
                    value="{{ $item->regulations_num }}">{{ $item->regulations_num . ' ' . $item->regulations_name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp7 = session('form_data')['reports_car_model_code'] ?? '';
        } else {
            $temp7 = null;
        }
        ?>
        {!! Form::label('reports_car_model_code', '車種代號') !!}
        {!! Form::text('reports_car_model_code', $temp7, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            $temp8 = session('form_data')['reports_test_date'] ?? '';
        } else {
            $temp8 = null;
        }
        ?>
        {!! Form::label('reports_test_date', '測試日期') !!}
        {!! Form::date('reports_test_date', $temp8, ['class' => 'form-control', 'min' => "1911-01-01", 'max' => "9999-12-31"]) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp9 = session('form_data')['reports_date'] ?? '';
        } else {
            $temp9 = null;
        }
        ?>
        {!! Form::label('reports_date', '報告日期') !!}
        {!! Form::date('reports_date', $temp9, ['class' => 'form-control', 'min' => "1911-01-01", 'max' => "9999-12-31"]) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp10 = session('form_data')['reports_vin'] ?? '';
        } else {
            $temp10 = null;
        }
        ?>
        {!! Form::label('reports_vin', '代表車車身碼(VIN)') !!}
        {!! Form::text('reports_vin', $temp10, ['class' => 'form-control']) !!}
    </div>

</div>
<div class="col-md-6">

    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp11 = session('form_data')['reports_authorize_count_before'] ?? 0;
        } else {
            $temp11 = null;
        }
        ?>
        {!! Form::label('reports_authorize_count_before', '移入前授權使用次數') !!}
        {!! Form::number('reports_authorize_count_before', $temp11, ['class' => 'form-control', 'min' => '0']) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp12 = session('form_data')['reports_authorize_count_current'] ?? 0;
        } else {
            $temp12 = null;
        }
        ?>
        {!! Form::label('reports_authorize_count_current', '移入後累計授權次數') !!}
        {!! Form::number('reports_authorize_count_current', $temp12, ['class' => 'form-control', 'min' => '0']) !!}
    </div>
    <div class="form-group position-relative">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            if (session('form_data')['reports_f_e'] == null) {
                $temp131 = '';
                $temp132 = '';
            } else {
                $temp131 = session('form_data')['reports_f_e'] == 'F' ? ' selected="selected"' : '';
                $temp132 = session('form_data')['reports_f_e'] == 'E' ? ' selected="selected"' : '';
            }
        } else {
            $temp131 = '';
            $temp132 = '';
        }
        ?>
        <label class="font-weight-bold" for="reports_f_e">F/E</label>
        <select class="form-control custom-select bg-white @error('reports_f_e') is-invalid @enderror"
            name="reports_f_e" id="reports_f_e">
            <option value="">請選擇</option>
            <option {{ ($detectionReport->reports_f_e ?? '') == 'F' ? ' selected="selected"' : '' }} {{ $temp131 }} value="F">F
            </option>
            <option {{ ($detectionReport->reports_f_e ?? '') == 'E' ? ' selected="selected"' : '' }} {{ $temp132 }} value="E">E
            </option>
        </select>
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp16 = session('form_data')['reports_vehicle_pattern'] ?? '';
        } else {
            $temp16 = $detectionReport->reports_vehicle_pattern ?? '';
        }
        ?>
        {!! Form::label('reports_vehicle_pattern', '車輛樣式') !!}
        {!! Form::select(
            'reports_vehicle_pattern',
            $carPattern,
            $temp16,
            ['class' => 'form-control'],
        ) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp17 = session('form_data')['reports_vehicle_doors'] ?? '';
        } else {
            $temp17 = null;
        }
        ?>
        {!! Form::label('reports_vehicle_doors', '門數') !!}
        {!! Form::text('reports_vehicle_doors', $temp17, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp18 = session('form_data')['reports_vehicle_cylinders'] ?? '';
        } else {
            $temp18 = null;
        }
        ?>
        {!! Form::label('reports_vehicle_cylinders', '汽缸數') !!}
        {!! Form::text('reports_vehicle_cylinders', $temp18, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp19 = session('form_data')['reports_vehicle_seats'] ?? '';
        } else {
            $temp19 = null;
        }
        ?>
        {!! Form::label('reports_vehicle_seats', '座位數') !!}
        {!! Form::text('reports_vehicle_seats', $temp19, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp20 = session('form_data')['reports_vehicle_fuel_category'] ?? '';
        } else {
            $temp20 = $detectionReport->reports_vehicle_fuel_category ?? '';
        }
        ?>
        {!! Form::label('reports_vehicle_fuel_category', '燃油類別') !!}
        {!! Form::select(
            'reports_vehicle_fuel_category',
            $carFuelCategory,
            $temp20,
            ['class' => 'form-control'],
        ) !!}
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp14 = session('form_data')['reports_reply'] ?? '';
        } else {
            $temp14 = null;
        }
        ?>
        {!! Form::label('reports_reply', '車安回函') !!}
        {!! Form::text('reports_reply', $temp14, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group {{ $mode == 'create' ? 'd-none' : '' }}">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            if (session('form_data')['reports_car_brand'] == null) {
                $temp15 = '';
            } else {
                $temp15 = session('form_data')['reports_authorize_status'] ?? '';
            }
        } else {
            $temp15 = '';
        }
        ?>
        <label class="font-weight-bold" for="reports_authorize_status">授權狀態</label>
        <select class="form-control custom-select bg-white @error('reports_authorize_status') is-invalid @enderror"
            name="reports_authorize_status" id="reports_authorize_status">
            <option value="">請選擇</option>
            @foreach ($authStatus as $item)
                <option
                    {{ ($detectionReport->reports_authorize_status ?? '') == $item->id ? ' selected="selected"' : '' }}
                    {{ $temp15 == $item->id ? ' selected="selected"' : '' }}
                    value="{{ $item->id }}">{{ $item->status_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <?php
        if (session()->has('form_data') && $mode == 'create') {
            // dd(session('form_data'));
            $temp16 = session('form_data')['reports_note'] ?? '';
        } else {
            $temp16 = null;
        }
        ?>
        {!! Form::label('reports_note', '說明') !!}
        <textarea class="form-control" name="reports_note" id="reports_note" rows="5">{{ $detectionReport->reports_note ?? '' }}{{ $temp16 }}</textarea>
    </div>
    <div class="form-group">
        {!! Form::label('reports_pdf', '檢測報告PDF') !!}

        <div class="custom-file">
            {!! Form::file('reports_pdf', null, ['class' => 'custom-file-input', 'required' => true]) !!}
            {{-- <input type="file" class="custom-file-input" id="reports_pdf" name="reports_pdf" accept="image/*"> --}}
            <label class="custom-file-label" for="reports_pdf">Choose file</label>
        </div>
    </div>
</div>
@push('page_css')
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: #444444 !important;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $('#reports_car_model').empty().select2({
            data: [],
            placeholder: '請先選擇廠牌',
            allowClear: true
        });
        $('#reports_regulations').select2({
            language: 'zh-TW',
            width: '100%',
            allowClear: true,
            // placeholder: '請選擇',
            tags: false,
            tokenSeparators: [',', ' ']
        })
        var modeCheck = '{{ $mode == 'edit' }}';
        // console.log(modeCheck);
        if (modeCheck) {
            setTimeout(() => {
                $('#reports_car_brand').change();

                var auth_status = "{{ ($detectionReport->reports_authorize_status ?? '') == '3' }}";
                if (auth_status && $('#letter_id').val() == '' && $('#reports_reply').val() == '') {
                    $('#reports_authorize_status').attr('disabled', true);
                }
            }, 1000);
        }

        var temp_brand = "{{ session()->has('form_data') ? session('form_data')['reports_car_brand'] ?? '' : ''; }}";
        var temp_model = "{{ session()->has('form_data') ? session('form_data')['reports_car_model'] ?? '' : ''; }}";
        var mode = "{{ $mode }}";
        if (mode == "create" && temp_brand != '') {
            setTimeout(() => {
                $('#reports_car_brand').change();
            }, 1000);
        }

        $('#reports_car_brand').change();
        $('#reports_car_brand').on('change', function() {
            $('#reports_car_model').prop('disabled', true);
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
                        var selected_id = "{{ $detectionReport->reports_car_model ?? '' }}";
                        $('#reports_car_model').empty();
                        $('#reports_car_model').append('<option value="">請先選擇廠牌</option>');
                        $.each(data, function(key, value) {
                            var selected = '';
                            if (selected_id == value.id || (mode == 'create' && temp_model ==
                                    value.id)) {
                                selected = ' selected="selected"';
                            }
                            $('#reports_car_model').append('<option ' + selected + ' value="' +
                                value.id + '">' + value
                                .model_name + '</option>');
                        });
                    },
                    complete: function(XMLHttpRequest, textStatus) {
                        setTimeout(function() {
                            $('#reports_car_model').prop('disabled', false);
                        }, 300);
                    },
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
