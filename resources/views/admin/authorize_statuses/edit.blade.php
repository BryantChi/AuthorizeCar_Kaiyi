@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>修改狀態項目</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($authorizeStatus, ['route' => ['admin.authorizeStatuses.update', $authorizeStatus->id], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('admin.authorize_statuses.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('儲存', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('admin.authorizeStatuses.index') }}" class="btn btn-default">取消</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
