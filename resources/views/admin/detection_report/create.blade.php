@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>新增檢測報告明細項目</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        @include('adminlte-templates::common.errors')

        <div class="card">

            <div class="container-fuild mt-3">
                <div class="row justify-content-end">
                    <div class="col-auto mx-3">
                        <a href="{{ route('admin.detectionReports.index') }}" class="btn btn-outline-primary">列表</a>
                    </div>
                </div>
            </div>

            <Form action="{{ route('admin.detectionReports.store') }}" method="post" class="needs-validation"
                enctype="multipart/form-data">

                <div class="card-body">

                    <div class="row">
                        @include('admin.detection_report.fields')
                    </div>

                </div>
                @csrf
                <div class="card-footer d-flex justify-content-end">
                    {!! Form::submit('儲存', ['class' => 'btn btn-primary mr-2']) !!}
                    <a href="{{ route('admin.detectionReports.index') }}" onclick="clearSessions()" class="btn btn-default">取消</a>
                </div>

            </Form>



        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('input[name=letter_id]').on('change', function() {
            $('#reports_authorize_status').prop('disabled', true);
            var letter_id = $('input[name=letter_id]').val();
            // console.log(letter_id);
            $.ajax({
                url: "{{ route('getStatusByLetter') }}",
                type: 'GET',
                data: {
                    enable: letter_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data) {
                    $('#reports_authorize_status').empty();
                    $('#reports_authorize_status').append('<option value="">請選擇</option>');
                    $.each(data, function(key, value) {
                        $('#reports_authorize_status').append('<option value="' + value.id +
                            '">' + value
                            .status_name + '</option>');
                    });
                },
                complete: function(XMLHttpRequest, textStatus) {
                    setTimeout(function(){
                        $('#reports_authorize_status').prop('disabled', false);
                    }, 300);
                },
            });
        });

        var formSubmitting = false;

        $('Form').on('submit', function() {
            formSubmitting = true;
        });
        window.addEventListener('beforeunload', function (e) {
            // 防止重複提交
            if (formSubmitting) {
                return undefined;
            }

            var formData = $('Form').serialize();
            $.ajax({
                url: "{{ route('saveDraft') }}",
                type: 'POST',
                data: formData,
                // dataType: 'json',
                success: function(data) {
                },
                complete: function(XMLHttpRequest, textStatus) {
                },
            });

            // 顯示提示給用戶
            e.preventDefault();
            // e.returnValue = '你有未保存的更改，確定離開嗎？';
        });

        function clearSessions() {
            formSubmitting = true;
            var sessionClear = "{{ session()->forget('form_data') }}";
        }
    </script>
@endpush
