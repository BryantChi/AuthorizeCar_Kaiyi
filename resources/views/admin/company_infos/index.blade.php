@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>公司資訊</h1>
                </div>
                <div class="col-sm-6">
                    @if (count($companyInfos) == 0)
                        <a class="btn btn-primary float-right" href="{{ route('admin.companyInfos.create') }}">
                            <i class="fas fa-plus"></i>
                            新增
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('admin.company_infos.table')

                <div class="card-footer clearfix">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $companyInfos])
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
