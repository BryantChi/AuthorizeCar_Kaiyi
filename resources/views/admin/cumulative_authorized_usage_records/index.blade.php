@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>授權次數明細紀錄</h1>
                </div>
                <div class="col-sm-6 d-none">
                    <a class="btn btn-primary float-right"
                        href="{{ route('admin.cumulativeAuthorizedUsageRecords.create') }}">
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
            <div class="card-body">
                <div class="form-group form-check mb-3 py-1 d-flex align-items-center btn btn-outline-secondary"
                    style="width: max-content;">
                    <input type="checkbox" class="form-check-input check-all mr-1 my-0 ml-1 d-none"
                        style="width: 20px;height: 20px;" id="check-all" value="" />
                    <label for="check-all" class="check-all-label px-2 mb-0 ml-42">全選</label>
                </div>
                @include('admin.cumulative_authorized_usage_records.table')

                {{-- <div class="card-footer clearfix">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', [
                            'records' => $cumulativeAuthorizedUsageRecords,
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

@push('third_party_stylesheets')
    <link href="https://cdn.datatables.net/v/dt/fc-4.3.0/datatables.min.css" rel="stylesheet">
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

            $.UrlParam = function(name) {
                //宣告正規表達式
                var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
                /*
                 * window.location.search 獲取URL ?之後的參數(包含問號)
                 * substr(1) 獲取第一個字以後的字串(就是去除掉?號)
                 * match(reg) 用正規表達式檢查是否符合要查詢的參數
                 */
                var r = window.location.search.substr(1).match(reg);
                //如果取出的參數存在則取出參數的值否則回穿null
                if (r != null) return unescape(r[2]);
                return null;
            }

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

            let scrollX_enable = "{{ count($caRecords) > 0 ? 1 : 0 }}" == true;
            if($(window).width() > 1500) { scrollX_enable = false }
            else { scrollX_enable = "{{ count($caRecords) > 0 ? 1 : 0 }}" == true; }

            var table = $('#cumulativeAuthorizedUsageRecords-table').DataTable({
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
                            // var select = $(
                            //         '<select class="form-control"><option value=""></option></select>'
                            //     )
                            //     .appendTo($(column.footer()).empty())
                            //     .on('change', function() {
                            //         var val = DataTable.util.escapeRegex($(this).val());

                            //         column
                            //             .search(val ? '^' + val + '$' : '', true, false)
                            //             .draw();
                            //     });
                            var select = $(column.footer()).find('select');
                            select.select2({
                                language: 'zh-TW',
                                width: '100%',
                                maximumInputLength: 100,
                                minimumInputLength: 0,
                                tags: true,
                                placeholder: '請選擇' + title,
                                allowClear: true
                            });

                            // Add list of options
                            if (title == '授權書編號' || title == '檢測報告編號' || title == '車身號碼' || title == '授權日期') {
                                $('<input type="text" class="form-control" placeholder="Search ' +
                                        title + '" />')
                                    .appendTo($(column.footer()).empty());
                                    // .on('keyup change clear', function() {
                                    //     if (column.search() !== this.value) {
                                    //         column.search(this.value).draw();
                                    //     }
                                    // });
                            } else {
                                // column
                                //     .data()
                                //     .unique()
                                //     .sort()
                                //     .each(function(d, j) {
                                //         let s = d;

                                //         select.append(
                                //             '<option value="' + s + '">' + s + '</option>'
                                //         );
                                //     });

                            }

                        });
                    table.columns().every(function() {
                        var that = this;
                        var title = that.header().textContent;
                        $('input', this.footer()).on('keyup change', function() {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        });

                        $('select', this.footer()).select2({
                            language: 'zh-TW',
                            width: '100%',
                            maximumInputLength: 100,
                            minimumInputLength: 0,
                            tags: false,
                            placeholder: '請選擇 ' + title,
                            allowClear: true
                        });

                        $('select', this.footer()).on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            // that.search(val ? '^' + val + '$' : '', true, false).draw();
                            that.search($(this).val()).draw();
                        });
                    });

                    $('.buttons-excel').removeClass('dt-button buttons-excel buttons-html5').addClass(
                        'btn btn-outline-info mr-2').html('匯出Excel');

                    if ($.UrlParam("q") != null && $.UrlParam("q") != '') {
                        table.column(4).search($.UrlParam("q")).draw();
                    } else {
                        table.draw();
                    }
                },
                ajax: {
                    url: "{{ route('admin.cumulativeAuthorizedUsageRecords.index') }}",
                    // data: function(d) {
                    //     d.reports_reporter = $('#drsh-report-reporter').val();
                    // }
                },
                processing: true,
                serverSide: true,
                deferRender: true,
                lengthChange: true, // 呈現選單
                lengthMenu: [10, 15, 20, 30, 50, 100, 500, 1000], // 選單值設定
                pageLength: 10, // 不用選單設定也可改用固定每頁列數
                // fixedHeader: true,
                // fixedColumns: {
                //     'left': 1, // 固定左边的1列
                //     // rightColumns: 1 // 固定右边的1列
                // },
                searching: true, // 搜索功能
                ordering: false,
                order: [[1, 'asc']],
                searching: true, // 搜索功能
                ordering: true,
                // stateSave: true, // 保留狀態
                scrollCollapse: true,
                scrollX: scrollX_enable,
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
                columns: [
                    // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    {
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'authorization_serial_number',
                        name: 'authorization_serial_number'
                    },
                    {
                        data: 'authorize_num',
                        name: 'authorize_num'
                    },
                    {
                        data: 'reports_num',
                        name: 'reports_num'
                    },
                    {
                        data: 'applicant',
                        name: 'applicant'
                    },
                    {
                        data: 'reports_vin',
                        name: 'reports_vin'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'authorization_date',
                        name: 'authorization_date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: 'Blfrtip', // 這行代碼是必須的，用於告訴 DataTables 插入哪些按鈕
                buttons: [{
                    extend: 'excel',
                    title: '累計授權使用紀錄',
                    // text: '導出已篩選的數據到 Excel',
                    exportOptions: {
                        modifier: {
                            search: 'applied', // 這裡確保只有已篩選的數據會被導出
                            order: 'applied' // 這裡確保導出的數據與目前的排序方式一致
                        },
                        rows: function(idx, data, node) {
                            return $(node).find('input[name="records[]"]').prop('checked');
                        },
                        // columns: function(idx, data, node) {
                        //     return idx != 0 && idx != 1 && idx != 9;
                        // },
                        columns: [4,2,3,5,6,7,8],
                    }
                }],
                rowReorder: true,
                columnDefs: [
                    { orderable: false, className: 'reorder', targets: 1, visible: false},
                    { orderable: false, targets: '_all' }
                ]

            });

            // setTimeout(function() {
            //     table.draw();
            //     $('.buttons-excel').removeClass('dt-button buttons-excel buttons-html5').addClass(
            //         'btn btn-outline-info mr-2').html('匯出Excel');


            //     if ($.UrlParam("q") != null && $.UrlParam("q") != '') {
            //         table.column(4).search($.UrlParam("q")).draw();
            //     } else {
            //         table.draw();
            //     }
            // }, 1000);
        })
    </script>
@endpush
