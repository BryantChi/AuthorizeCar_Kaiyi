@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>同意授權使用證明書記錄</h1>
                </div>
                <div class="col-sm-6 d-none">
                    <a class="btn btn-primary float-right" href="{{ route('admin.agreeAuthorizeRecords.create') }}">
                        <i class="fas fa-plus"></i>
                        新增
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        {{-- <div class="clearfix"></div> --}}

        <div class="card">
            <div class="card-body overflow-hidden">
                <div class="form-group form-check mb-3 py-1 d-flex align-items-center btn btn-outline-secondary"
                    style="width: max-content;">
                    <input type="checkbox" class="form-check-input check-all mr-1 my-0 ml-1 d-none"
                        style="width: 20px;height: 20px;" id="check-all" value="" />
                    <label for="check-all" class="check-all-label px-2 mb-0 ml-42">全選</label>
                </div>
                @include('admin.agree_authorize_records.table')

                {{-- <div class="card-footer clearfix">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', [
                            'records' => $agreeAuthorizeRecords,
                        ])
                    </div>
                </div> --}}
            </div>

        </div>
    </div>
@endsection

@push('page_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
    <style>
        .select2-container {
            width: 100% !important;
        }

        .ft-none input,
        .ft-none select,
        .ft-none .select2 {
            display: none !important;
        }
    </style>
@endpush

@push('page_scripts')
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js">
    </script>
    <script src="https://cdn.datatables.net/v/dt/fc-4.3.0/datatables.min.js"></script>
    <script>
        $(function() {

            $('#check-all').change(function() {
                if ($(this).is(':checked')) {
                    var rows = table.rows({
                        'page': 'current'
                    }).nodes();
                    $('.check-all-label').html('取消全選');
                    $('input[name="records[]"]', rows).prop('checked', true);
                    // $('input[name="records[]"]', rows).change();
                } else {
                    $('.check-all-label').html('全選');
                    $('input[name="records[]"]', rows).prop('checked', false);
                    // $('input[name="records[]"]', rows).change();
                }
            });

            var table = $('#agreeAuthorizeRecords-table').DataTable({
                // initComplete: function() {
                //     this.api()
                //         .columns()
                //         .every(function() {
                //             var column = this;
                //             var title = column.footer().textContent;

                //             // Create input element and add event listener
                //             $('<input type="text" placeholder="Search ' + title + '" />')
                //                 .appendTo($(column.footer()).empty())
                //                 .on('keyup change clear', function() {
                //                     if (column.search() !== this.value) {
                //                         column.search(this.value).draw();
                //                     }
                //                 });
                //         });
                // },
                initComplete: function() {
                    this.api()
                        .columns()
                        .every(function() {
                            var column = this;
                            var title = column.footer().textContent;

                            // Create select element and listener
                            var select = $(
                                    '<select class="form-control"><option value=""></option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on('change', function() {
                                    var val = DataTable.util.escapeRegex($(this).val());

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            select.select2({
                                language: 'zh-TW',
                                width: '100%',
                                maximumInputLength: 10,
                                minimumInputLength: 0,
                                tags: true,
                                placeholder: '請選擇' + title,
                                allowClear: true
                            });

                            // Add list of options
                            if (title == '授權項目') {
                                $('<input type="text" class="form-control" placeholder="Search ' +
                                        title + '" />')
                                    .appendTo($(column.footer()).empty())
                                    .on('keyup change clear', function() {
                                        if (column.search() !== this.value) {
                                            column.search(this.value).draw();
                                        }
                                    });
                            } else {
                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function(d, j) {
                                        let s = d;

                                        select.append(
                                            '<option value="' + s + '">' + s + '</option>'
                                        );
                                    });

                            }

                        });
                },
                lengthChange: true, // 呈現選單
                lengthMenu: [10, 15, 20, 30, 50], // 選單值設定
                pageLength: 10, // 不用選單設定也可改用固定每頁列數
                // fixedHeader: true,
                // fixedColumns: {
                //     'left': 1, // 固定左边的1列
                //     // rightColumns: 1 // 固定右边的1列
                // },
                searching: true, // 搜索功能
                ordering: true,
                // stateSave: true, // 保留狀態
                scrollCollapse: true,
                scrollX: true,
                scrollY: '60vh',
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.11.3/i18n/zh_Hant.json"
                },
                // columnDefs: [{
                //     'targets': 0,
                //     'searchable': false,
                //     'orderable': false,
                //     'className': 'dt-body-center',
                //     'render': function(data, type, full, meta) {
                //         var d = JSON.parse(data);
                //         return '<input type="checkbox" name="records[]"  style="width: 20px;height: 20px;" value="' +
                //             $('<div/>').text(d.id).html() + '" >';
                //     }
                // }],
                dom: 'Blfrtip',  // 這行代碼是必須的，用於告訴 DataTables 插入哪些按鈕
                buttons: [
                    {
                        extend: 'excel',
                        // text: '導出已篩選的數據到 Excel',
                        exportOptions: {
                            modifier: {
                                search: 'applied',  // 這裡確保只有已篩選的數據會被導出
                                order: 'applied'   // 這裡確保導出的數據與目前的排序方式一致
                            },
                            rows: function (idx, data, node) {
                                return $(node).find('input[name="records[]"]').prop('checked');
                            },
                            columns: function(idx, data, node) {
                                return idx != 0;
                            },
                        }
                    }
                ],


            });

            setTimeout(function() {
                table.draw();
                $('.buttons-excel').removeClass('dt-button buttons-excel buttons-html5').addClass('btn btn-outline-info mr-2').html('匯出Excel');
            }, 1000);
        })
    </script>
@endpush
