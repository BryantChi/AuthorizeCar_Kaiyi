@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>燃油類別</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('admin.carFuelCategories.index') }}">
                        返回
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('admin.car_fuel_categories.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
