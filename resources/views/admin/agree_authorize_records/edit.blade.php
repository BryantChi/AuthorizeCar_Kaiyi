@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Agree Authorize Records</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($agreeAuthorizeRecords, ['route' => ['admin.agreeAuthorizeRecords.update', $agreeAuthorizeRecords->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('admin.agree_authorize_records.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.agreeAuthorizeRecords.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
