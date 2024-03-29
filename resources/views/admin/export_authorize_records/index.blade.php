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

        <div class="card card-authorize" id="card-authorize">
            <div class="card-body">
                @include('admin.detection_report.applyAuthorize')
            </div>
        </div>

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

    <div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">檔案下載</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center file-container">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">關閉</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
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
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
    <style>
        .select2-container {
            width: 100% !important;
        }

        .has-error .select2-selection {
            border-color: rgb(185, 74, 72) !important;
        }

        .ft-none input,
        .ft-none select,
        .ft-none .select2 {
            display: none !important;
        }

        @media(min-width:768px) {
            .authorize-temp-conatiner {
                border-left: 1px solid #444444bf;
            }
        }

        @media(max-width:768px) {
            .authorize-temp-conatiner {
                border-top: 1px solid #444444bf;
            }
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
            $('#card-authorize').hide();
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

            let scrollX_enable = "{{ count($exportAuthorizeRecords) > 0 ? 1 : 0 }}" == true;
            // if ($(window).width() > 1500) {
            //     scrollX_enable = false;
            // } else {
            //     scrollX_enable = "{{ count($exportAuthorizeRecords) > 0 ? 1 : 0 }}" == true;
            // }
            var table = $('#exportAuthorizeRecords-table').DataTable({
                // initComplete: function() {
                //     this.api()
                //         .columns()
                //         .every(function() {
                //             var column = this;
                //             var title = column.footer().textContent;

                //             // Create input element and add event listener
                //             $('<input type="text" class="form-control" placeholder="Search ' +
                //                     title + '" />')
                //                 .appendTo($(column.footer()).empty());
                //                 // .on('keyup change clear', function() {
                //                 //     if (column.search() !== this.value) {
                //                 //         column.search(this.value).draw();
                //                 //     }
                //                 // });
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
                                .appendTo($(column.footer()).empty());
                                // .on('change', function() {
                                //     var val = DataTable.util.escapeRegex($(this).val());

                                //     column
                                //         .search(val ? '^' + val + '$' : '', true, false)
                                //         .draw();
                                // });

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
                            if (title == '授權書編號' || title == '授權使用對象' || title == '樣式年份' || title == '車身碼' || title == '授權日期' ||
                            title == '授權使用序號' || title == '檢測報告編號' || title == '廠牌' || title == '型號' || title == '備註') {
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
                        table.column(1).search($.UrlParam("q").replace('TWCAR-', '')).draw();
                    } else {
                        table.draw();
                    }
                },
                ajax: {
                    url: "{{ route('admin.exportAuthorizeRecords.index') }}",
                    // data: function(d) {
                    //     d.reports_reporter = $('#drsh-report-reporter').val();
                    // }
                },
                processing: true,
                serverSide: true,
                deferRender: true,
                lengthChange: true, // 呈現選單
                lengthMenu: [10, 15, 20, 30, 50, 100, 500], // 選單值設定
                pageLength: 10, // 不用選單設定也可改用固定每頁列數
                fixedHeader: true,
                fixedColumns: {
                    'left': 2, // 固定左边的1列
                    // rightColumns: 1 // 固定右边的1列
                },
                searching: true, // 搜索功能
                ordering: true,
                // stateSave: true, // 保留狀態
                scrollCollapse: true,
                scrollX: scrollX_enable,
                scrollY: '60vh',
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.11.3/i18n/zh_Hant.json"
                },
                columns: [
                    // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    {
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'export_authorize_num',
                        name: 'export_authorize_num'
                    },
                    {
                        data: 'export_authorize_com',
                        name: 'export_authorize_com'
                    },
                    {
                        data: 'export_authorize_brand',
                        name: 'export_authorize_brand'
                    },
                    {
                        data: 'export_authorize_model',
                        name: 'export_authorize_model'
                    },
                    {
                        data: 'export_authorize_type_year',
                        name: 'export_authorize_type_year'
                    },
                    {
                        data: 'export_authorize_vin',
                        name: 'export_authorize_vin'
                    },
                    {
                        data: 'export_authorize_date',
                        name: 'export_authorize_date'
                    },
                    {
                        data: 'export_authorize_auth_num_id',
                        name: 'export_authorize_auth_num_id'
                    },
                    {
                        data: 'export_authorize_reports_nums',
                        name: 'export_authorize_reports_nums'
                    },
                    {
                        data: 'export_authorize_path',
                        name: 'export_authorize_path'
                    },
                    {
                        data: 'export_authorize_note',
                        name: 'export_authorize_note'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
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
                    title: '授權開立紀錄',
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
                            return idx != 0 && idx != 10 && idx != 12;
                            // return idx != 0 && idx != 7 && idx != 10 && idx != 12;
                        },
                    }
                }],


            });

            // setTimeout(function() {
            //     if ($.UrlParam("q") != null && $.UrlParam("q") != '') {
            //         table.column(1).search($.UrlParam("q")).draw();
            //     } else {
            //         table.draw();
            //     }
            //     $('.buttons-excel').removeClass('dt-button buttons-excel buttons-html5').addClass(
            //         'btn btn-outline-info mr-2').html('匯出Excel');
            // }, 1000);

            $('#car_model').empty().select2({
                data: [],
                placeholder: '請先選擇廠牌',
                allowClear: true
            });

            $('#car_brand').on('change', function() {
                $('#car_model').prop('disabled', true);
                var brand_id = $(this).val();
                if (brand_id) {
                    $.ajax({
                        url: "{{ route('getModelsByBrand') }}",
                        type: 'GET',
                        data: {
                            brand_id: brand_id,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            // $('#car_model').empty().select2({
                            //     data: data.map(item => ({
                            //         id: item.id,
                            //         text: item.model_name
                            //     })),
                            //     placeholder: '請先選擇廠牌',
                            //     allowClear: true
                            // });
                            $('#car_model').empty();
                            $('#car_model').append('<option value="">請先選擇廠牌</option>');
                            $.each(data, function(key, value) {
                                $('#car_model').append('<option value="' + value.id +
                                    '">' + value.model_name + '</option>');
                            });
                        },
                        complete: function(XMLHttpRequest, textStatus) {
                            setTimeout(function() {
                                $('#car_model').prop('disabled', false);
                            }, 300);
                        },
                    });
                } else {
                    // $('#reports_car_model').empty().select2({
                    //     data: [],
                    //     placeholder: '請先選擇廠牌',
                    //     allowClear: true
                    // });
                    $('#reports_car_model').empty();
                    $('#reports_car_model').append('<option value="">請先選擇廠牌</option>');
                }
            });

            $.ajax({
                url: '{{ route('getReportsByRegs') }}',
                type: 'GET',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data) {
                    $('#reports_num').empty();
                    $('#reports_num').append('<option value="">請先選擇法規項目</option>');
                    $.each(data, function(key, value) {
                        $('#reports_num').append('<option value="' + value.id +
                            '" data-expirationdate="' + value
                            .reports_expiration_date_end + '" data-fe="' +
                            value.reports_f_e + '" data-countbefore="' +
                            value.reports_authorize_count_before +
                            '" data-countcurrent="' + value
                            .reports_authorize_count_current + '" ' +
                            'data-regs="' + value.reports_regulations + '">' + value
                            .reports_num + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    setTimeout(function() {
                        $('#reports_num').prop('disabled', false);
                    }, 300);
                },
                complete: function(XMLHttpRequest, textStatus) {
                    setTimeout(function() {
                        $('#reports_num').prop('disabled', false);
                    }, 300);
                },
            });

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
                        $('p#reports_num').html(res.data.reports_num);
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


        let reports_data = [];
        let check_reports_data = [];
        var isProcess = false;

        async function applyForAuthorize(mode, auth_export_id = null) {
            $('#card-authorize').slideDown(1500);

            $('.btn-auth-cancel').click(function() {
                reports_data = [];
                check_reports_data = [];
                inputEmpty();
                $('#card-authorize').slideUp(750);
            });

            $('#addAuth').click(function() {

                if ($('#reports_num').val() == '' || $('#inputAuthNum').val() == '') {
                    // if ($('#reports_regulations').val() == '') {
                    //     $('#reports_regulations').parent().addClass('has-error');
                    // } else {
                    //     $('#reports_regulations').parent().removeClass('has-error');
                    // }

                    if ($('#reports_num').val() == '') {
                        $('#reports_num').parent().addClass('has-error');
                    } else {
                        $('#reports_num').parent().removeClass('has-error');
                    }

                    if ($('#inputAuthNum').val() == '') {
                        $('#inputAuthNum').addClass('is-invalid');
                    } else {
                        $('#inputAuthNum').removeClass('is-invalid');
                    }

                    Swal.fire('注意！', '輸入不能為空', 'warning');
                } else {
                    $('#reports_regulations').parent().removeClass('has-error').css('border-color', '$aaa');
                    $('#reports_num').parent().removeClass('has-error').css('border-color', '$aaa');
                    $('#inputAuthNum').removeClass('is-invalid').css('border-color', '$aaa');

                    if ($.inArray($('#reports_num').val(), reports_data) == -1) {
                        reports_data.push($('#reports_num').val());
                        let regs_txt_temp = $('#reports_regulations').find(':selected').text()
                            .replace(new RegExp('\n', 'g'), ',')
                            .replace(new RegExp('                            ', 'g'), '')
                            .substring(1);
                        let reports_num_temp = $('#reports_num').find(':selected').text();
                        let auth_num_temp = $('#inputAuthNum').val();
                        if ($('#reports_regulations').val() == '') {
                            var regss = $('#reports_num').find(':selected').data('regs');
                            $.ajax({
                                url: "{{ route('getRegs') }}",
                                type: 'GET',
                                data: {
                                    regs: regss,
                                    _token: '{{ csrf_token() }}',
                                },
                                dataType: 'json',
                                success: function(data) {
                                    regs_txt_temp = '';
                                    $.each(data, function(key, value) {
                                        if (key == 0) {
                                            regs_txt_temp += value.regulations_num + ' ' +
                                                value.regulations_name;
                                        } else {
                                            regs_txt_temp += ',' + value.regulations_num +
                                                ' ' + value.regulations_name;
                                        }
                                    });
                                    $('#authorize-data-temp-table tbody').append('<tr id="' + $(
                                            '#reports_num').val() +
                                        '">' +
                                        '<td style="max-width: 300px;">' + regs_txt_temp +
                                        '</td>' +
                                        '<td>' + reports_num_temp + '</td>' +
                                        '<td>' + auth_num_temp + '</td>' +
                                        '<td><a herf="javascript:void(0)" class="btn btn-danger" onclick="deleteTempAuth(\'' +
                                        $('#reports_num').val() + '\')" >刪除</a></td>' +
                                        '</tr>');
                                },
                            });
                        } else {
                            $('#authorize-data-temp-table tbody').append('<tr id="' + $('#reports_num').val() +
                                '">' +
                                '<td style="max-width: 300px;">' + regs_txt_temp + '</td>' +
                                '<td>' + reports_num_temp + '</td>' +
                                '<td>' + auth_num_temp + '</td>' +
                                '<td><a herf="javascript:void(0)" class="btn btn-danger" onclick="deleteTempAuth(\'' +
                                $('#reports_num').val() + '\')" >刪除</a></td>' +
                                '</tr>');
                        }
                    }
                    // console.log(reports_data);
                    // if (reports_data.length > 0) {
                    //     $('#btn-auth').prop('disabled', false);
                    // } else {
                    //     $('#btn-auth').prop('disabled', true);
                    // }
                }
            });

            $('#reports_regulations').change(function() {
                // $('#reports_num').prop('disabled', true);
                $('#inputAuthNum').val('');
                let regs = $(this).val();
                // if (regs.length > 0) {
                    $.ajax({
                        url: '{{ route('getReportsByRegs') }}',
                        type: 'GET',
                        data: {
                            regs: regs,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('#reports_num').empty();
                            $('#reports_num').append('<option value="">請先選擇法規項目</option>');
                            $.each(data, function(key, value) {
                                $('#reports_num').append('<option value="' + value.id +
                                    '" data-expirationdate="' + value
                                    .reports_expiration_date_end + '" data-fe="' +
                                    value.reports_f_e + '" data-countbefore="' +
                                    value.reports_authorize_count_before +
                                    '" data-countcurrent="' + value
                                    .reports_authorize_count_current + '" ' +
                                    'data-regs="' + value.reports_regulations + '">' + value
                                    .reports_num + '</option>');
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            setTimeout(function() {
                                $('#reports_num').prop('disabled', false);
                            }, 300);
                        },
                        complete: function(XMLHttpRequest, textStatus) {
                            setTimeout(function() {
                                $('#reports_num').prop('disabled', false);
                            }, 300);
                        },
                    });
                // }

            });

            $('#reports_num').change(function() {
                if ($('#reports_num').val() != null && $('#reports_num').val() != '') {
                    // let e_date = $(this).find(':selected').data('expirationdate').split('-');
                    // let e_date_y = e_date[0] - 1911;
                    // let e_date_m = padZero(e_date[1], 2);
                    // let e_date_d = padZero(e_date[2], 2);
                    // let auth_count = 0;
                    // if ($(this).find(':selected').data('countcurrent') < $(this).find(':selected').data(
                    //         'countbefore')) {
                    //     auth_count = padZero(($(this).find(':selected').data('countbefore') + 1), 3);
                    // } else {
                    //     if ($.inArray($(this).find(':selected').val(), check_reports_data) != -1 && mode == 'edit') {
                    //         auth_count = padZero(($(this).find(':selected').data('countcurrent')), 3);
                    //     } else {
                    //         auth_count = padZero(($(this).find(':selected').data('countcurrent') + 1), 3);
                    //     }

                    // }
                    // let fe = '';
                    // if ($(this).find(':selected').data('fe') != null) fe = $(this).find(':selected').data('fe');
                    // let authorize_id = $(this).find(':selected').text() + '-Y' + fe + e_date_y + e_date_m + e_date_d + '-' + auth_count;
                    // $('#inputAuthNum').val(authorize_id);

                    let num = $(this).find(':selected').text();
                    let url = "{{ route('getReportByNum') }}";
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            num: num,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            let e_date = data.report_data.reports_expiration_date_end.split('-');
                            let e_date_y = e_date[0] - 1911;
                            let e_date_m = padZero(e_date[1], 2);
                            let e_date_d = padZero(e_date[2], 2);
                            let auth_count = 0;
                            if (data.report_data.reports_authorize_count_current < data.report_data.reports_authorize_count_before) {
                                auth_count = padZero((data.report_data.reports_authorize_count_before + 1), 3);
                            } else {
                                auth_count = padZero((data.report_data.reports_authorize_count_current + 1), 3);
                            }
                            let fe = '';
                            if (data.report_data.reports_f_e != null) fe = data.report_data.reports_f_e;
                            let authorize_id = data.report_data.reports_num + '-Y' + fe + e_date_y + e_date_m + e_date_d + '-' + auth_count;
                            $('#inputAuthNum').val(authorize_id);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                        },
                        complete: function(XMLHttpRequest, textStatus) {
                        },
                    })
                }
            });

            if (mode == 'edit') {
                $('#btn-auth').html('修改並開立');
            } else {
                $('#btn-auth').html('開立');
            }
            $('#btn-auth').click(function() {
                // prevent_reloading();
                $('#btn-auth').prop('disabled', true);

                if ($('#inp_com').val() == '' || $('#car_brand').val() == '' || $('#car_model').val() ==
                    '' || $('#inp_vin').val() == '' || $('#inp_auth_num').val() == '' ||
                    $('#inp_auth_type_year').val() == '' || reports_data.length == 0) {
                    if ($('#inp_com').val() == '') {
                        $('#inp_com').addClass('is-invalid');
                    } else {
                        $('#inp_com').removeClass('is-invalid');
                    }

                    if ($('#car_brand').val() == '') {
                        $('#car_brand').parent().addClass('has-error');
                    } else {
                        $('#car_brand').parent().removeClass('has-error');
                    }

                    if ($('#car_model').val() == '') {
                        $('#car_model').parent().addClass('has-error');
                    } else {
                        $('#car_model').parent().removeClass('has-error');
                    }

                    if ($('#inp_auth_type_year').val() == '') {
                        $('#inp_auth_type_year').addClass('is-invalid');
                    } else {
                        $('#inp_auth_type_year').removeClass('is-invalid');
                    }

                    if ($('#inp_vin').val() == '') {
                        $('#inp_vin').addClass('is-invalid');
                    } else {
                        $('#inp_vin').removeClass('is-invalid');
                    }

                    if ($('#inp_auth_num').val() == '') {
                        $('#inp_auth_num').addClass('is-invalid');
                    } else {
                        $('#inp_auth_num').removeClass('is-invalid');
                    }

                    if (isProcess == true) {
                        isProcess = false;
                    }

                    Swal.fire('注意！', '輸入不能為空及授權項目至少一項', 'warning').then(function () {
                        $('#btn-auth').prop('disabled', false);
                    });
                } else {
                    const formValues = [$('#inp_com').val(), $('#car_brand').val(), $('#car_model').val(),
                        $('#inp_vin').val(), $('#inp_auth_num').val(), $('#inp_auth_date').val(),
                        $('#inp_auth_type_year').val(), $('#inp_auth_note').val()
                    ];

                    if (isProcess == false) {
                        isProcess = true;
                    } else {
                        return;
                    }

                    // $('#authorizationModal').modal('hide');
                    Swal.fire({
                        title: '處理中...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('exportDocument') }}",
                        type: 'POST',
                        data: {
                            data_ids: reports_data,
                            typer: 'authorize',
                            mode: mode,
                            auth_export_id: auth_export_id,
                            auth_input: formValues,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.close();
                            if (res.status == 'success') {
                                $('.file-container').empty();
                                $('.file-container').append(
                                    '<div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">' +
                                    '<a href="' + window.location.origin + '/' + res
                                    .authorize_data
                                    .word + '" download>' +
                                    '<p class="text-secondary file-name" style="max-width: 200px;">' +
                                    res
                                    .authorize_data.authorize_file_name + '</p>' +
                                    '<img src="{{ asset('assets/img/word-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                    '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                    '</a>' +
                                    '</div>' +
                                    '<div class="col-auto d-block pdf-download-content text-center mx-3">' +
                                    '<a href="' + window.location.origin + '/' + res
                                    .authorize_data
                                    .pdf + '" download>' +
                                    '<p class="text-secondary file-name" style="max-width: 200px;">' +
                                    res
                                    .authorize_data.authorize_file_name + '</p>' +
                                    '<img src="{{ asset('assets/img/pdf-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                    '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                    '</a>' +
                                    '</div>');

                                // $('.btn-close').click(function () {
                                //     window.location.reload();
                                // });
                                setTimeout(function() {
                                    $('#downloadModal').modal('show');
                                    $('#downloadModal').on('hidden.bs.modal', function(
                                        event) {
                                        // do something...
                                        reports_data = [];
                                        check_reports_data = [];
                                        Swal.fire({
                                            title: '載入中...',
                                            allowOutsideClick: false,
                                            showConfirmButton: false,
                                            didOpen: () => {
                                                Swal.showLoading();
                                            }
                                        });
                                        window.location.reload();
                                    });
                                }, 500);


                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            reports_data = [];
                            check_reports_data = [];
                            Swal.fire('錯誤！', '程序失敗', 'error').then(function() {
                                window.location.reload();
                            });
                        }
                    });
                }


            });
        }

        async function inputEmpty() {
            $('#inp_com').val('');
            $('#car_brand').val(null).trigger('change');
            $('#car_model').val(null).trigger('change');
            $('#inp_vin').val('');
            $('#inp_auth_num').val('');
            $('#inp_auth_date').val('');
            $('#inp_auth_type_year').val(new Date().getFullYear());
            $('#inp_auth_note').val('');

            $('#reports_regulations').val([]).trigger('change');
            $('#reports_num').val(null).trigger('change');
            $('#inputAuthNum').val('');
            $('#authorize-data-temp-table tbody').empty();
        }

        function padZero(number, length) {
            // 將 number 轉換為字符串
            var str = number.toString();

            // 如果 str 的長度小於指定的 length，則在前面補零
            while (str.length < length) {
                str = "0" + str;
            }

            return str;
        }

        function deleteTempAuth(temp) {
            $('#' + temp).remove();
            reports_data.splice($.inArray(temp, reports_data), 1);
            // if (reports_data.length > 0) {
            //     $('#btn-auth').prop('disabled', false);
            // } else {
            //     $('#btn-auth').prop('disabled', true);
            // }
        }

        function convertToGregorian(dateString) {
            // 將日期字符串分割為年、月、日
            var parts = dateString.split('/');

            // 將民國年份轉換為數字並加上1911
            var year = parseInt(parts[0], 10) + 1911;

            // 組合成西元紀年的日期格式
            return year + '-' + parts[1] + '-' + parts[2];
        }

        async function autoInputAuth(jsonObj, mode) {
            reports_data = jsonObj.reports_ids;
            check_reports_data = Array.from(reports_data);

            $('#inp_com').val(jsonObj.export_authorize_com);
            $('#car_brand').val(jsonObj.export_authorize_brand).trigger('change');
            setTimeout(() => {
                $('#car_model').val(jsonObj.export_authorize_model).trigger('change');
            }, 1500);
            $('#inp_vin').val(jsonObj.export_authorize_vin);
            $('#inp_auth_num').val(jsonObj.export_authorize_num);
            $('#inp_auth_date').val(convertToGregorian(jsonObj.export_authorize_date));
            $('#inp_auth_type_year').val(jsonObj.export_authorize_type_year);
            $('#inp_auth_note').val(jsonObj.export_authorize_note);

            $.ajax({
                url: "{{ route('getReportsData') }}",
                type: "POST",
                data: {
                    data_ids: reports_data,
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    if (res.status == 'success') {
                        // console.log(res.reports);
                        // console.log(res.regulations);
                        $('#authorize-data-temp-table tbody').empty();
                        $.each(res.reports, function(index, report) {
                            let regs_txt_temp = '';

                            $.each(res.regulations[report.id], function(i, val) {
                                if (i == 0) {
                                    regs_txt_temp += val.regulations_num + ' ' + val
                                        .regulations_name;
                                } else {
                                    regs_txt_temp += ',' + val.regulations_num + ' ' + val
                                        .regulations_name;
                                }

                            });

                            let e_date = report.reports_expiration_date_end.split('-');
                            let e_date_y = e_date[0] - 1911;
                            let e_date_m = padZero(e_date[1], 2);
                            let e_date_d = padZero(e_date[2], 2);
                            if (report.reports_authorize_count_current < report
                                .reports_authorize_count_before) {
                                auth_count = padZero((report.reports_authorize_count_before + 1),
                                    3);
                            } else {
                                if (mode == 'edit') {
                                    auth_count = padZero((report.reports_authorize_count_current),
                                        3);
                                } else {
                                    auth_count = padZero((report.reports_authorize_count_current +
                                        1), 3);
                                }
                            }
                            let fe0 = '';
                            if (report.reports_f_e != null) fe0 = report.reports_f_e;
                            let auth_num_temp = report.reports_num + '-Y' + fe0 +
                                e_date_y + e_date_m + e_date_d + '-' + auth_count;

                            $('#authorize-data-temp-table tbody').append('<tr id="' + report.id +
                                '">' +
                                '<td style="max-width: 300px;">' + regs_txt_temp + '</td>' +
                                '<td>' + report.reports_num + '</td>' +
                                '<td>' + auth_num_temp + '</td>' +
                                '<td><a herf="javascript:void(0)" class="btn btn-danger" onclick="deleteTempAuth(\'' +
                                    report.id + '\')" >刪除</a></td>' +
                                '</tr>');
                        });


                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire('錯誤！', '程序失敗', 'error').then(function() {
                        window.location.reload();
                    });
                }
            });
        }

        async function copy(item) {
            let str = item.replace(/(\n)/g,'\\n');
            str = str.replace(/(\r)/g,'\\r');
            let jsonObj = JSON.parse(str);
            // console.log(jsonObj);
            await autoInputAuth(jsonObj);

            await applyForAuthorize('copy');
        }

        async function edit(item) {
            let str = item.replace(/(\n)/g,'\\n');
            str = str.replace(/(\r)/g,'\\r');
            let jsonObj = JSON.parse(str);
            // console.log(jsonObj);
            await autoInputAuth(jsonObj, 'edit');

            await applyForAuthorize('edit', jsonObj.id);
        }

        // function prevent_reloading(){
        //     var pendingRequests = {};
        //         jQuery.ajaxPrefilter(function( options, originalOptions, jqXHR ) {
        //             var key = options.url;
        //             console.log(key);
        //             if (!pendingRequests[key]) {
        //                 pendingRequests[key] = jqXHR;
        //             }else{
        //                 //jqXHR.abort();    //放棄後觸發的提交
        //                 pendingRequests[key].abort();   // 放棄先觸發的提交
        //             }
        //             var complete = options.complete;
        //             options.complete = function(jqXHR, textStatus) {
        //                 pendingRequests[key] = null;
        //                 if (jQuery.isFunction(complete)) {
        //                 complete.apply(this, arguments);
        //                 }
        //             };
        //         });
        // }
    </script>
@endpush
