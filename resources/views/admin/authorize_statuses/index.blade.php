@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>狀態項目</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.authorizeStatuses.create') }}">
                       <i class="fas fa-plus"></i>
                        新增
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('admin.authorize_statuses.table')

                {{-- <div class="card-footer clearfix">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $authorizeStatuses])
                    </div>
                </div> --}}
            </div>

        </div>
    </div>

@endsection

@push('page_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
@endpush

@push('page_scripts')
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js">
    </script>
    <script>
        $(function() {
            let scrollX_enable = "{{ count($authorizeStatuses) > 0 ? 1 : 0 }}" == true;
            if($(window).width() > 1200) { scrollX_enable = false }
            else { scrollX_enable = "{{ count($authorizeStatuses) > 0 ? 1 : 0 }}" == true; }

            var table = $('#authorizeStatuses-table').DataTable({
                lengthChange: true, // 呈現選單
                lengthMenu: [10, 15, 20, 30, 50], // 選單值設定
                pageLength: 10, // 不用選單設定也可改用固定每頁列數

                searching: true, // 搜索功能
                ordering: true,
                // stateSave: true, // 保留狀態
                scrollCollapse: true,
                scrollX: scrollX_enable,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.11.3/i18n/zh_Hant.json"
                },
                // columnDefs: [{
                //     'targets': 0,
                //     'searchable': false,
                //     'orderable': false,
                //     'className': 'dt-body-center',
                //     'render': function (data, type, full, meta) {
                //         var d = JSON.parse(data);
                //         return '<input type="checkbox" name="reports[]"  style="width: 20px;height: 20px;" value="' + $('<div/>').text(d.id).html() + '" data-letter="' + $('<div/>').text(d.letter_id).html() + '" data-status="' + $('<div/>').text(d.reports_authorize_status).html() + '">';
                //     }
                // }],
                // dom: 'Bfrtip',  // 這行代碼是必須的，用於告訴 DataTables 插入哪些按鈕
                // buttons: [
                //     {
                //         extend: 'excel',
                //         // text: '導出已篩選的數據到 Excel',
                //         exportOptions: {
                //             modifier: {
                //                 search: 'applied',  // 這裡確保只有已篩選的數據會被導出
                //                 order: 'applied'   // 這裡確保導出的數據與目前的排序方式一致
                //             },
                //             rows: function (idx, data, node) {
                //                 return $(node).find('input[name="reports[]"]').prop('checked');
                //             },
                //             columns: [1,2,3,4,5,6,7,8,9,10,11,14,15,17],
                //         }
                //     }
                // ],
            });
        })

        setTimeout(() => {
            table.draw();
        }, 600);

    </script>
@endpush

