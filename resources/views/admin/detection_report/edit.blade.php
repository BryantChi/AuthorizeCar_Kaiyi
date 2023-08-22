@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>修改檢測報告明細項目</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($detectionReport, ['route' => ['admin.detectionReports.update', $detectionReport->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('admin.detection_report.fields')
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
                {!! Form::submit('儲存', ['class' => 'btn btn-primary mr-2']) !!}
                <a href="{{ route('admin.detectionReports.index') }}" class="btn btn-default">取消</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
