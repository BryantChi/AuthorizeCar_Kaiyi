@extends('layouts.app')

@section('content')
<div class="container" style="height: 45vmin;">
    <div class="row justify-content-center h-100">
        <div class="col-md-6 text-center align-self-end">
            <a href="{{ route('admin.detectionReports.create') }}" class="btn btn-outline-primary btn-lg">
                開始新增
            </a>
        </div>
    </div>
</div>
@endsection
