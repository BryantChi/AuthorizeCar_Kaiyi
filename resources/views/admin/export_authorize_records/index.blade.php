@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>授權開立紀錄</h1>
                </div>
                <div class="col-sm-6 d-none">
                    <a class="btn btn-primary float-right" href="{{ route('admin.exportAuthorizeRecords.create') }}">
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
            <div class="card-body">
                <div class="form-group form-check mb-3 py-1 d-flex align-items-center btn btn-outline-secondary"
                    style="width: max-content;">
                    <input type="checkbox" class="form-check-input check-all mr-1 my-0 ml-1 d-none"
                        style="width: 20px;height: 20px;" id="check-all" value="" />
                    <label for="check-all" class="check-all-label px-2 mb-0 ml-42">全選</label>
                </div>
                @include('admin.export_authorize_records.table')

                {{-- <div class="card-footer clearfix">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $exportAuthorizeRecords])
                    </div>
                </div> --}}
            </div>

        </div>
    </div>

    <div class="modal fade" id="reportShowModal" tabindex="-1" aria-labelledby="reportShowModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportShowModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row p-3">
                        <div class="col-12">
                            <label for="letter_id">發函文號</label>
                            <p id="letter_id"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_num">檢測報告編號</label>
                            <p id="reports_num"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_expiration_date_end">有效期限-迄</label>
                            <p id="reports_expiration_date_end"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_reporter">報告原有人</label>
                            <p id="reports_reporter"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_car_brand">廠牌</label>
                            <p id="reports_car_brand"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_car_model">型號</label>
                            <p id="reports_car_model"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_inspection_institution">檢測機構</label>
                            <p id="reports_inspection_institution"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_regulations">法規項目</label>
                            <p id="reports_regulations"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_car_model_code">車種代號</label>
                            <p id="reports_car_model_code"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_test_date">測試日期</label>
                            <p id="reports_test_date"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_date">報告日期</label>
                            <p id="reports_date"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_vin">代表車車身碼(VIN)</label>
                            <p id="reports_vin"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_authorize_count_before">移入前授權使用次數</label>
                            <p id="reports_authorize_count_before"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_authorize_count_current">移入後累計授權次數</label>
                            <p id="reports_authorize_count_current"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_f_e">F/E</label>
                            <p id="reports_f_e"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_reply">車安回函</label>
                            <p id="reports_reply"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_authorize_status">授權狀態</label>
                            <p id="reports_authorize_status"></p>
                        </div>
                        <div class="col-12">
                            <label for="reports_note">說明</label>
                            <p id="reports_note"></p>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
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

            let scrollX_enable = "{{ count($exportAuthorizeRecords) > 0 ? '"true"' : '"false"' }}";
            if ($(window).width() > 1500) {
                scrollX_enable = false;
            } else {
                scrollX_enable = "{{ count($exportAuthorizeRecords) > 0 ? '"true"' : '"false"' }}";
            }
            var table = $('#exportAuthorizeRecords-table').DataTable({
                initComplete: function() {
                    this.api()
                        .columns()
                        .every(function() {
                            var column = this;
                            var title = column.footer().textContent;

                            // Create input element and add event listener
                            $('<input type="text" class="form-control" placeholder="Search ' +
                                    title + '" />')
                                .appendTo($(column.footer()).empty())
                                .on('keyup change clear', function() {
                                    if (column.search() !== this.value) {
                                        column.search(this.value).draw();
                                    }
                                });
                        });
                },
                // initComplete: function() {
                //     this.api()
                //         .columns()
                //         .every(function() {
                //             var column = this;
                //             var title = column.footer().textContent;

                //             // Create select element and listener
                //             var select = $(
                //                     '<select class="form-control"><option value=""></option></select>'
                //                 )
                //                 .appendTo($(column.footer()).empty())
                //                 .on('change', function() {
                //                     var val = DataTable.util.escapeRegex($(this).val());

                //                     column
                //                         .search(val ? '^' + val + '$' : '', true, false)
                //                         .draw();
                //                 });

                //             select.select2({
                //                 language: 'zh-TW',
                //                 width: '100%',
                //                 maximumInputLength: 10,
                //                 minimumInputLength: 0,
                //                 tags: true,
                //                 placeholder: '請選擇' + title,
                //                 allowClear: true
                //             });

                //             // Add list of options
                //             if (title == '授權項目') {
                //                 $('<input type="text" class="form-control" placeholder="Search ' +
                //                         title + '" />')
                //                     .appendTo($(column.footer()).empty())
                //                     .on('keyup change clear', function() {
                //                         if (column.search() !== this.value) {
                //                             column.search(this.value).draw();
                //                         }
                //                     });
                //             } else {
                //                 column
                //                     .data()
                //                     .unique()
                //                     .sort()
                //                     .each(function(d, j) {
                //                         let s = d;

                //                         select.append(
                //                             '<option value="' + s + '">' + s + '</option>'
                //                         );
                //                     });

                //             }

                //         });
                // },
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
                dom: 'Blfrtip', // 這行代碼是必須的，用於告訴 DataTables 插入哪些按鈕
                buttons: [{
                    extend: 'excel',
                    // text: '導出已篩選的數據到 Excel',
                    exportOptions: {
                        modifier: {
                            search: 'applied', // 這裡確保只有已篩選的數據會被導出
                            order: 'applied' // 這裡確保導出的數據與目前的排序方式一致
                        },
                        rows: function(idx, data, node) {
                            return $(node).find('input[name="records[]"]').prop('checked');
                        },
                        columns: function(idx, data, node) {
                            return idx != 0 && idx != 8;
                        },
                    }
                }],


            });

            setTimeout(function() {
                if ($.UrlParam("q") != null && $.UrlParam("q") != '') {
                    table.column(1).search($.UrlParam("q")).draw();
                } else {
                    table.draw();
                }
                $('.buttons-excel').removeClass('dt-button buttons-excel buttons-html5').addClass(
                    'btn btn-outline-info mr-2').html('匯出Excel');


            }, 1000);

        });

        function openReport(reportId) {
            Swal.fire({
                title: '載入中...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: "{{ route('showReportModal') }}",
                type: 'POST',
                data: {
                    reportId: reportId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    Swal.close();
                    if (res.status == 'success') {
                        console.log(res.data);
                        $('#letter_id').html(res.data.letter_id);
                        $('#reports_num').html(res.data.reports_num);
                        $('#reports_expiration_date_end').html(res.data
                            .reports_expiration_date_end);
                        $('#reports_reporter').html(res.data.reports_reporter);
                        $('#reports_car_brand').html(res.data.reports_car_brand);
                        $('#reports_car_model').html(res.data.reports_car_model);
                        $('#reports_inspection_institution').html(res.data
                            .reports_inspection_institution);
                        $('#reports_regulations').html(res.data.reports_regulations);
                        $('#reports_car_model_code').html(res.data.reports_car_model_code);
                        $('#reports_test_date').html(res.data.reports_test_date);
                        $('#reports_date').html(res.data.reports_date);
                        $('#reports_vin').html(res.data.reports_vin);
                        $('#reports_authorize_count_before').html(res.data
                            .reports_authorize_count_before);
                        $('#reports_authorize_count_current').html(res.data
                            .reports_authorize_count_current);
                        $('#reports_f_e').html(res.data.reports_f_e);
                        $('#reports_reply').html(res.data.reports_reply);
                        $('#reports_authorize_status').html(res.data.reports_authorize_status);
                        $('#reports_note').html(res.data.reports_note);
                        setTimeout(function() {
                            $('#reportShowModal').modal('show');
                        }, 500);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire('錯誤！', '程序失敗', 'error');
                }
            })

        }
    </script>
@endpush
