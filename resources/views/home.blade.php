@extends('layouts.app')

@section('content')
<div class="container" style="height: 45vmin;">
    <div class="row justify-content-center h-100">
        <div class="col-md-6 text-center align-self-end">
            <a href="{{ route('admin.detectionReports.create') }}" class="btn btn-outline-primary btn-lg">
                開始新增
            </a>
            <div class="w-75 mt-5 mx-auto d-none">
                <form action="{{ route('importReport') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        {!! Form::label('dri_file', '匯入檢測報告', ['class' => 'h5']) !!}

                        <div class="custom-file">
                            <input type="file" name="dri_file" class="custom-file-input" accept=".xlsx, .xls">
                            <label class="custom-file-label" for="reports_pdf">Choose file</label>
                        </div>
                    </div>
                    <button class="btn btn-outline-primary"type="submit">Import Report</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
