@extends('layouts.app')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>檢測報告明細列表</h1>
            </div>
            <div class="col-sm-6">
                <a class="btn btn-primary float-right"
                   href="{{ route('admin.detectionReports.create') }}">
                   <i class="fas fa-plus"></i>
                    新增
                </a>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid">
    @include('flash::message')
    <div class="card mx-3">
        <div class="card-body">
            @include('admin.detection_report.table')
        </div>
    </div>

</div>
@endsection
