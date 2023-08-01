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

                <div class="card-footer d-flex justify-content-end">
                    {!! Form::submit('儲存', ['class' => 'btn btn-primary mr-2']) !!}
                    <a href="{{ route('admin.detectionReports.index') }}" class="btn btn-default">取消</a>
                </div>

            </Form>



        </div>
    </div>
@endsection
