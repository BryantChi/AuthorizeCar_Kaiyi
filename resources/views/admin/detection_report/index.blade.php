@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-between">
                <div class="col-sm-auto">
                    <h1>檢測報告總表</h1>
                </div>
                <div class="col-sm-auto ">
                    <a class="btn btn-primary float-right" href="{{ route('admin.detectionReports.create') }}">
                        <i class="fas fa-plus"></i>
                        新增
                    </a>
                    <div class="float-right d-flex mr-2">
                        <div class="btn-action" id="btn-action">
                            <a class="btn btn-outline-success mr-2 mb-md-auto mb-2" id="btn-apply-delivery"
                                href="javascript:void(0)" onclick="applyForDelivery()">
                                申請送件
                            </a>
                            <a class="btn btn-outline-success mr-2 mb-md-auto mb-2" id="btn-apply-authorize"
                                href="javascript:void(0)" onclick="applyForAuthorize()">
                                開立授權
                            </a>
                            <a class="btn btn-outline-success mr-2 mb-md-auto mb-2" id="btn-move-out"
                                href="javascript:void(0)" onclick="moveOut()">
                                移出
                            </a>
                            <a class="btn btn-outline-success mr-2 mb-md-auto mb-2" id="btn-postpone"
                                href="javascript:void(0)" onclick="postpone()">
                                展延
                            </a>
                            <a class="btn btn-outline-success mr-2 mb-md-auto mb-2" id="btn-reply" href="javascript:void(0)"
                                onclick="reply()">
                                已回函
                            </a>
                        </div>

                        {{-- <div class="dropdown" id="export-step-1">
                            <a class="btn btn-outline-secondary dropdown-toggle" href="javascript:void(0)" role="button"
                                data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-download"></i> 匯出
                            </a>

                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" href="javascript:void(0)"
                                    onclick="exportInventory()">登錄清冊</a>
                                <a class="dropdown-item" href="#" href="javascript:void(0)"
                                    onclick="exportContract()">移入合約書</a>
                                <a class="dropdown-item" href="#" href="javascript:void(0)"
                                    onclick="exportApplicationLetter()">申請函</a>
                            </div>
                        </div> --}}
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        @include('flash::message')

        <div class="card card-authorize" id="card-authorize">
            <div class="card-body">
                @include('admin.detection_report.applyAuthorize')
            </div>
        </div>

        <div class="card">
            <div class="card-body overflow-hidden">
                <div class="d-flex">
                    <div class="form-group form-check mb-3 py-1 d-flex align-items-center btn btn-outline-secondary"
                        style="width: max-content;">
                        <input type="checkbox" class="form-check-input check-all mr-1 my-0 ml-1 d-none"
                            style="width: 20px;height: 20px;" id="check-all" value="" />
                        <label for="check-all" class="check-all-label px-2 mb-0 ml-42">全選</label>
                    </div>
                    <div class="ml-auto mb-3" style="width: max-content;">
                        <a class="btn btn-outline-secondary" id="resetTableState" href="javascript:void(0)">重新整理</a>
                    </div>
                </div>

                @include('admin.detection_report.table')

                {{-- <div class="card-footer clearfix">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', [
                            'records' => $detectionReports ?? '',
                        ])
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
                        {{-- <div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">
                            <a href="javascript:void(0)" download>
                                <p class="file-name"></p>
                                <img src="{{ asset('assets/img/word-icon.png') }}" class="img-fluid" width="80"
                                    alt="">
                                <p class="text-secondary font-weight-lighter">點擊即可下載</p>
                            </a>
                        </div>
                        <div class="col-auto d-block pdf-download-content text-center mx-3">
                            <a href="javascript:void(0)" download>
                                <p class="file-name"></p>
                                <img src="{{ asset('assets/img/pdf-icon.png') }}" class="img-fluid" width="80"
                                    alt="">
                                <p class="text-secondary font-weight-lighter">點擊即可下載</p>
                            </a>
                        </div>
                        <div class="col-auto d-block pdf-download-content text-center mx-3">
                            <a href="javascript:void(0)" download>
                                <p class="file-name"></p>
                                <img src="{{ asset('assets/img/excel-icon.png') }}" class="img-fluid" width="80"
                                    alt="">
                                <p class="text-secondary font-weight-lighter">點擊即可下載</p>
                            </a>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">關閉</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- PdfModal -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="pdfModalLabel">Modal title</h5> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- {{ env('APP_URL') . '/uploads/' }} --}}
                    <iframe id="pdf-data" src="" width="100%" style="height: 100vh;" seamless scrolling="yes"
                        type="application/pdf" frameborder="0"></iframe>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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

        #recentSearches {
            width: 233px;
            display: none;
            position: absolute;
            z-index: 1000;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            right: 0;
        }

        .recentSearchLink {
            color: grey;
            cursor: pointer;
            margin-bottom: 0;
        }

        .recentSearchLink:hover {
            background-color: #7066e020;
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
        let reports_data = [];
        $(function() {
            $('#card-authorize').hide();
            // $('.btn-action').hide();
            // $('#export-step-1').hide();
            // $('#detectionReports-table tbody').on('change', 'input[name="reports[]"]', function() {
            //     var ck_reports = $('input[name="reports[]"]:checked').map(function() {
            //         return $(this).val();
            //     }).get();
            //     if (ck_reports.length > 0) {
            //         $('.btn-action').show(600);
            //     } else {
            //         $('.btn-action').hide(600);
            //         // $('#export-step-1').hide();
            //     }
            // });

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
                    $('input[name="reports[]"]', rows).prop('checked', true);
                    // $('input[name="reports[]"]', rows).change();
                } else {
                    $('.check-all-label').html('全選');
                    $('input[name="reports[]"]', rows).prop('checked', false);
                    // $('input[name="reports[]"]', rows).change();
                }
            });

            var table = $('#detectionReports-table').DataTable({
                // initComplete: function() {
                //     this.api()
                //         .columns()
                //         .every(function() {
                //             var column = this;
                //             var title = column.footer().textContent;

                //             // Create input element and add event listener
                //             $('<input type="text" class="form-control" placeholder="Search ' + title + '" />')
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
                            // var select = $(
                            //         '<select class="form-control"><option value=""></option></select>'
                            //     )
                            //     .appendTo($(column.footer()).empty());
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
                                maximumInputLength: 10,
                                minimumInputLength: 0,
                                tags: true,
                                placeholder: '請選擇',
                                allowClear: true
                            });

                            // Add list of options
                            if (title == '檢測報告編號' || title == '法規項目' || title == '有效期限-迄' ||
                                title == '測試日期' || title ==
                                '報告日期') {
                                $('<input type="text" class="form-control" placeholder="Search ' +
                                        title + '"  />')
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
                                //         // if (title == '法規項目') {
                                //         //     // console.log(d);
                                //         //     let charToRemove =
                                //         //         '<span class="rounded mr-1 my-1 py-1 px-2 bg-info d-flex float-left" style="width: max-content;">';
                                //         //     let charToRemove2 = '</span>';
                                //         //     s = d.replace(new RegExp(charToRemove, 'g'), '');
                                //         //     s = s.replace(new RegExp(charToRemove2, 'g'), '');
                                //         //     s = s.replace(new RegExp("\n", 'g'), ' ');
                                //         //     s = s.replace(new RegExp(
                                //         //         "                                                    ",
                                //         //         'g'), '')
                                //         //     console.log(s);
                                //         // }

                                //         select.append(
                                //             '<option value="' + s + '">' + s + '</option>'
                                //         );
                                //     });

                            }

                        });
                    table.columns().every(function() {
                        var that = this;
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
                            placeholder: '請選擇',
                            allowClear: true
                        });

                        $('select', this.footer()).on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            // that.search(val ? '^' + val + '$' : '', true, false).draw();
                            that.search($(this).val()).draw();
                        });
                    });

                    displayRecentSearches();

                    $(".fancybox").fancybox({
                        // width  : "60vh",
                        // height : "100vh",
                        type: 'iframe',
                        iframe: {
                            css: {
                                width: '100vh',
                                height: "90vh",
                            }
                        }
                    });

                    if ($.UrlParam("auth_apply") != null && $.UrlParam("auth_apply") != '' && $
                        .UrlParam(
                            "auth_apply") == 'on') {
                        $('#btn-apply-authorize').click();
                    }

                    $('.buttons-excel').removeClass('dt-button buttons-excel buttons-html5').addClass(
                        'btn btn-outline-info mr-2').html('匯出Excel');
                },
                ajax: {
                    url: "{{ route('admin.detectionReports.index') }}",
                    // data: function(d) {
                    //     d.reports_reporter = $('#drsh-report-reporter').val();
                    // }
                },
                processing: true,
                serverSide: true,
                deferRender: true,
                lengthChange: true, // 呈現選單
                lengthMenu: [
                    [10, 15, 20, 30, 50, 100, 500, -1],
                    [10, 15, 20, 30, 50, 100, 500, "全部"]
                ], // 選單值設定
                pageLength: 10, // 不用選單設定也可改用固定每頁列數
                fixedHeader: true,
                fixedColumns: {
                    'left': 2, // 固定左边列
                    // rightColumns: 1 // 固定右边列
                },
                searching: true, // 搜索功能
                ordering: true,
                stateSave: true, // 保留狀態
                scrollCollapse: true,
                scrollX: true,
                scrollY: '60vh',
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.11.3/i18n/zh_Hant.json"
                },
                search: {
                    // "regex": true,
                    return: true
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
                        data: 'reports_num',
                        name: 'reports_num'
                    },
                    {
                        data: 'letter_id',
                        name: 'letter_id'
                    },
                    {
                        data: 'reports_authorize_status',
                        name: 'reports_authorize_status'
                    },
                    {
                        data: 'reports_expiration_date_end',
                        name: 'reports_expiration_date_end'
                    },
                    {
                        data: 'reports_reporter',
                        name: 'reports_reporter'
                    },
                    {
                        data: 'reports_car_brand',
                        name: 'reports_car_brand'
                    },
                    {
                        data: 'reports_car_model',
                        name: 'reports_car_model'
                    },
                    {
                        data: 'reports_inspection_institution',
                        name: 'reports_inspection_institution'
                    },
                    {
                        data: 'reports_regulations',
                        name: 'reports_regulations'
                    },
                    {
                        data: 'reports_car_model_code',
                        name: 'reports_car_model_code'
                    },
                    {
                        data: 'reports_test_date',
                        name: 'reports_test_date'
                    },
                    {
                        data: 'reports_date',
                        name: 'reports_date'
                    },
                    {
                        data: 'reports_vin',
                        name: 'reports_vin'
                    },
                    {
                        data: 'reports_authorize_count_before',
                        name: 'reports_authorize_count_before'
                    },
                    {
                        data: 'reports_authorize_count_current',
                        name: 'reports_authorize_count_current'
                    },
                    {
                        data: 'reports_f_e',
                        name: 'reports_f_e'
                    },
                    {
                        data: 'reports_reply',
                        name: 'reports_reply'
                    },
                    {
                        data: 'reports_note',
                        name: 'reports_note'
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
                //         return '<input type="checkbox" name="reports[]"  style="width: 20px;height: 20px;" value="' +
                //             $('<div/>').text(d.id).html() + '" data-letter="' + $('<div/>')
                //             .text(d.letter_id).html() + '" data-status="' + $('<div/>').text(d
                //                 .reports_authorize_status).html() + '">';
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
                            return $(node).find('input[name="reports[]"]').prop('checked');
                        },
                        columns: function(idx, data, node) {
                            return idx != 0 && idx != 19;
                        },
                    }
                }],


            });


            $('#resetTableState').click(function() {
                // localStorage.removeItem("DataTables_detectionReports-table_/{{ route('admin.detectionReports.index') }}");
                table.state.clear();
                window.location.reload();
                // setTimeout(function() {
                // table.draw();
                // table.ajax.reload(null, false);
                // }, 500);

            });

            setTimeout(() => {
                var searchBox = $('div.dataTables_filter input');
                var recentSearchesDiv = $(
                    '<div id="recentSearches" class="text-right border p-2" style="border-radius: 5px;"></div>'
                    ).insertAfter(searchBox);

                searchBox.on('focus', function() {
                    displayRecentSearches();
                    recentSearchesDiv.show();
                }).on('blur', function() {
                    // Use a timeout to allow users to click on the recent searches before hiding them
                    setTimeout(function() {
                        recentSearchesDiv.hide();
                    }, 200);
                });

                if ($.UrlParam("auth_apply") != null && $.UrlParam("auth_apply") != '' && $.UrlParam(
                        "auth_apply") == 'on') {
                    $('#btn-apply-authorize').click();
                }
            }, 600);

            // setTimeout(function() {
            //     // table.draw();

            //     table.columns().every(function() {
            //         var that = this;
            //         $('input', this.footer()).on('keyup change', function() {
            //             if (that.search() !== this.value) {
            //                 that.search(this.value).draw();
            //             }
            //         });

            //         $('select', this.footer()).select2({
            //             language: 'zh-TW',
            //             width: '100%',
            //             maximumInputLength: 100,
            //             minimumInputLength: 0,
            //             tags: false,
            //             placeholder: '請選擇',
            //             allowClear: true
            //         });

            //         $('select', this.footer()).on('change', function() {
            //             var val = $.fn.dataTable.util.escapeRegex($(this).val());
            //             // that.search(val ? '^' + val + '$' : '', true, false).draw();
            //             that.search($(this).val()).draw();
            //         });
            //     });

            //     displayRecentSearches();

            //     $(".fancybox").fancybox({
            //         // width  : "60vh",
            //         // height : "100vh",
            //         type: 'iframe',
            //         iframe: {
            //             css: {
            //                 width: '100vh',
            //                 height: "90vh",
            //             }
            //         }
            //     });

            //     $('.buttons-excel').removeClass('dt-button buttons-excel buttons-html5').addClass(
            //         'btn btn-outline-info mr-2').html('匯出Excel');
            // }, 3600);



            table.on('search.dt', function() {
                var searchValue = table.search();
                var searches = JSON.parse(localStorage.getItem('dtSearches') || '[]');

                // Remove the search value if it already exists (to avoid duplicates)
                var index = searches.indexOf(searchValue);
                if (index !== -1) {
                    searches.splice(index, 1);
                }

                // Add the new search value to the beginning
                searches.unshift(searchValue);

                // Keep only the last 5 searches
                if (searches.length > 6) {
                    searches.pop();
                }

                localStorage.setItem('dtSearches', JSON.stringify(searches));
                displayRecentSearches();
            });

            function displayRecentSearches() {
                var searches = JSON.parse(localStorage.getItem('dtSearches') || '[]');
                // var searchBox = $('div.dataTables_filter input');
                var recentSearchesDiv = $('#recentSearches');

                // if (!recentSearchesDiv.length) {
                //     recentSearchesDiv = $('<div id="recentSearches"></div>').insertAfter(searchBox);
                // }

                recentSearchesDiv.empty();

                searches.forEach(function(search) {
                    var searchLink = $('<p class="mb-0 p-1 recentSearchLink"></p>').text(search).on('click',
                        function(e) {
                            e.preventDefault();
                            table.search(search).draw();
                        });
                    if (search.length > 0) {
                        recentSearchesDiv.append(searchLink).append('');
                    }
                });
            }



            $('#car_model').empty().select2({
                data: [],
                placeholder: '請先選擇廠牌',
                allowClear: true
            });

            $('#car_brand').change();
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

            $(".fancybox").fancybox({
                // width  : "60vh",
                // height : "100vh",
                type: 'iframe',
                iframe: {
                    css: {
                        width: '100vh',
                        height: "90vh",
                    }
                }
            });
        });



        function getReportsCheckbox() { // 申請送件

            var ck_reports = $('input[name="reports[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            var checkReportLetter = $('input[name="reports[]"]:checked').map(function() {
                return $(this).data('letter');
            }).get();

            if (ck_reports.length == 0) {
                Swal.fire('注意！', '請選擇至少一個項目！', 'warning');
                return [];
            } else {
                if (areAllValuesSame(checkReportLetter)) {
                    return ck_reports;
                } else {
                    Swal.fire('注意！', '發函文號需相同！', 'warning');
                    return [];
                }
            }

        }

        function getReportsCheckboxForStatus(status) {

            var ck_reports = $('input[name="reports[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            var checkReportLetter = $('input[name="reports[]"]:checked').map(function() {
                return $(this).data('letter');
            }).get();

            var checkReportStatus = $('input[name="reports[]"]:checked').map(function() {
                return $(this).data('status');
            }).get();

            if (ck_reports.length == 0) {
                Swal.fire('注意！', '請選擇至少一個項目！', 'warning');
                return [];
            } else {
                switch (status) {
                    case 'authorize':
                        var validValues = [5, 6, 7];
                        if (containsOnly(checkReportStatus, validValues)) {
                            return ck_reports;
                        } else {
                            Swal.fire('注意！', '開立授權需為以下狀態：可開立授權、即將到期、即將達上限！', 'warning');
                            return [];
                        }
                        break;
                    case 'delivery':
                        var validValues = [2];
                        if (areAllValuesSame(checkReportLetter)) {
                            return ck_reports;
                        } else {
                            Swal.fire('注意！', '發函文號需相同！', 'warning');
                            return [];
                        }
                        break;
                    case 'reply':
                        var validValues = [3];
                        if (areAllValuesSame(checkReportLetter) && containsOnly(checkReportStatus, validValues)) {
                            return ck_reports;
                        } else {
                            Swal.fire('注意！', '發函文號需相同且狀態皆需為已送件！', 'warning');
                            return [];
                        }
                        break;
                    case 'moveout':
                        var validValues = [13];
                        if (areAllValuesSame(checkReportLetter) && containsOnly(checkReportStatus, validValues)) {
                            return ck_reports;
                        } else {
                            Swal.fire('注意！', '發函文號需相同且狀態皆需為移出！', 'warning');
                            return [];
                        }
                        break;
                    case 'postpone':
                        var validValues = [14];
                        if (areAllValuesSame(checkReportLetter) && containsOnly(checkReportStatus, validValues)) {
                            return ck_reports;
                        } else {
                            Swal.fire('注意！', '發函文號需相同且狀態皆需為展延！', 'warning');
                            return [];
                        }
                        break;

                    default:
                        break;
                }
            }

        }

        function containsOnly(arr, validValues) {
            return arr.every(value => validValues.includes(value));
        }

        function areAllValuesSame(arr) {
            for (var i = 1; i < arr.length; i++) {
                if (arr[i] !== arr[0]) {
                    return false;
                }
            }
            return true;
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

        function applyForDelivery() {
            var reports_id = getReportsCheckboxForStatus('delivery');

            // if (reports_id.length > 0) {
            //     $('#export-step-1').show();
            // } else {
            //     $('#export-step-1').hide();
            // }

            if (reports_id.length > 0) {
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
                        data_ids: reports_id,
                        typer: 'delivery',
                        mode: null,
                        auth_export_id: null,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        // var report = JSON.parse(res);
                        // console.log(res.data[0].original.file_name);
                        // console.log(window.location.host + report.word);
                        // if (report.status == 'success') {
                        //     $('.word-download-content>a').attr('href', window.location.origin + '/' + report
                        //         .word);
                        //     $('.word-download-content>a').prop('href', window.location.origin + '/' + report
                        //         .word);
                        //     $('.pdf-download-content>a').attr('href', window.location.origin + '/' + report
                        //         .pdf);
                        //     $('.pdf-download-content>a').prop('href', window.location.origin + '/' + report
                        //         .pdf);
                        //     setTimeout(function() {
                        //         $('#downloadModal').modal('show');
                        //         // window.open(window.location.origin + '/' + report.pdf);
                        //         // window.location.herf = " ('', ['convert' => '" + report.word + "']) ";
                        //     }, 500);
                        // }
                        Swal.close();
                        if (res.status == 'success') {
                            $('.file-container').empty();
                            $('.file-container').append(
                                '<div class="col-12"></div><div class="col-12"><h5>合約書</h5></div>');
                            res.contract_data.forEach(element => {
                                $('.file-container').append(
                                    '<div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">' +
                                    '<a href="' + window.location.origin + '/' + element
                                    .word + '" download>' +
                                    '<p class="text-secondary file-name" style="max-width: 200px;">' +
                                    element.contract_file_name + '</p>' +
                                    '<img src="{{ asset('assets/img/word-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                    '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                    '</a>' +
                                    '</div>' +
                                    '<div class="col-auto d-block pdf-download-content text-center mx-3">' +
                                    '<a href="' + window.location.origin + '/' + element
                                    .pdf + '" download>' +
                                    '<p class="text-secondary file-name" style="max-width: 200px;">' +
                                    element.contract_file_name + '</p>' +
                                    '<img src="{{ asset('assets/img/pdf-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                    '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                    '</a>' +
                                    '</div>');
                            });

                            $('.file-container').append(
                                '<div class="col-12"></div><div class="col-12 mt-3"><h5><申請函/h5></div>');
                            $('.file-container').append(
                                '<div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">' +
                                '<a href="' + window.location.origin + '/' + res.apply_letter_data
                                .word + '" download>' +
                                '<p class="text-secondary file-name" style="max-width: 200px;">' + res
                                .apply_letter_data.apply_letter_file_name + '</p>' +
                                '<img src="{{ asset('assets/img/word-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                '</a>' +
                                '</div>' +
                                '<div class="col-auto d-block pdf-download-content text-center mx-3">' +
                                '<a href="' + window.location.origin + '/' + res.apply_letter_data
                                .pdf + '" download>' +
                                '<p class="text-secondary file-name" style="max-width: 200px;">' + res
                                .apply_letter_data.apply_letter_file_name + '</p>' +
                                '<img src="{{ asset('assets/img/pdf-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                '</a>' +
                                '</div>');

                            $('.file-container').append(
                                '<div class="col-12"></div><div class="col-12 mt-3"><h5>登錄清冊</h5></div>');
                            $('.file-container').append(
                                '<div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">' +
                                '<a href="' + window.location.origin + '/' + res.data_entry_data
                                .excel + '" download>' +
                                '<p class="text-secondary file-name" style="max-width: 200px;">' + res
                                .data_entry_data.data_entry_file_name + '</p>' +
                                '<img src="{{ asset('assets/img/excel-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                '</a>' +
                                '</div>');

                            setTimeout(function() {
                                $('#downloadModal').modal('show');
                            }, 500);
                        }

                    }
                })
            }

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
        async function applyForAuthorize() {

            // var reports_id = getReportsCheckboxForStatus('authorize');


            // Swal.fire('注意！', '開發中！', 'warning');

            // const {
            //     value: formValues
            // } = await Swal.fire({
            //     title: '開立授權',
            //     html: '<input id="swal-input1" class="swal2-input" placeholder="輸入授權公司" required="true">' +
            //         '<input id="swal-input2" class="swal2-input" placeholder="輸入廠牌" required="true">' +
            //         '<input id="swal-input3" class="swal2-input" placeholder="輸入車型" required="true">' +
            //         '<input id="swal-input4" class="swal2-input" placeholder="輸入車身碼" required="true">',
            //     focusConfirm: false,
            //     showCancelButton: true,
            //     preConfirm: () => {
            //         if (document.getElementById('swal-input1').value != '' && document.getElementById(
            //                 'swal-input2').value != '' && document.getElementById(
            //                 'swal-input3').value != '' && document.getElementById('swal-input4')
            //             .value != '') {

            //             return [
            //                 document.getElementById('swal-input1').value,
            //                 document.getElementById('swal-input2').value,
            //                 document.getElementById('swal-input3').value,
            //                 document.getElementById('swal-input4').value
            //             ];
            //         } else {
            //             Swal.showValidationMessage('輸入不能為空');
            //         }
            //     }
            // })

            // $('#authorizationModal').modal('show');

            $('#card-authorize').slideDown(1500);

            $('.btn-auth-cancel').click(function() {
                reports_data = [];
                $('#inp_com').val('');
                $('#car_brand').val(null).trigger('change');
                $('#car_model').val(null).trigger('change');
                $('#inp_vin').val('');
                $('#inp_auth_num').val('');

                $('#reports_regulations').val([]).trigger('change');
                $('#reports_num').val(null).trigger('change');
                $('#inputAuthNum').val('');
                $('#authorize-data-temp-table tbody').empty();
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
                        var regs_txt_temp = $('#reports_regulations').find(':selected').text()
                            .replace(new RegExp('\n', 'g'), ',')
                            .replace(new RegExp('                            ', 'g'), '')
                            .substring(1);
                        let reports_num_temp = $('#reports_num').find(':selected').text();
                        let auth_num_temp = $('#inputAuthNum').val();
                        if ($('#reports_regulations').val() == '') {
                            var regss = [$('#reports_num').find(':selected').data('regs')];
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
                    let e_date = $(this).find(':selected').data('expirationdate').split('-');
                    let e_date_y = e_date[0] - 1911;
                    let e_date_m = padZero(e_date[1], 2);
                    let e_date_d = padZero(e_date[2], 2);
                    let auth_count = 0;
                    if ($(this).find(':selected').data('countcurrent') < $(this).find(':selected').data(
                            'countbefore')) {
                        auth_count = padZero(($(this).find(':selected').data('countbefore') + 1), 3);
                    } else {
                        auth_count = padZero(($(this).find(':selected').data('countcurrent') + 1), 3);
                    }
                    let authorize_id = $(this).find(':selected').text() + '-Y' + $(this).find(':selected').data(
                        'fe') + e_date_y + e_date_m + e_date_d + '-' + auth_count;
                    $('#inputAuthNum').val(authorize_id);
                }
            });

            $('#btn-auth').click(function() {

                if ($('#inp_com').val() == '' || $('#car_brand').val() == '' || $('#car_model').val() ==
                    '' || $('#inp_vin').val() == '' || $('#inp_auth_num').val() == '' || reports_data.length ==
                    0) {
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

                    Swal.fire('注意！', '輸入不能為空及授權項目至少一項', 'warning');
                } else {
                    const formValues = [$('#inp_com').val(), $('#car_brand').val(), $('#car_model').val(),
                        $('#inp_vin').val(), $('#inp_auth_num').val()
                    ];

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
                            mode: 'create',
                            auth_export_id: null,
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
                            Swal.fire('錯誤！', '程序失敗', 'error').then(function() {
                                window.location.reload();
                            });
                        }
                    });
                }


            });


        }

        function moveOut() {

            var reports_id = getReportsCheckboxForStatus('moveout');

            if (reports_id.length > 0) {
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
                        data_ids: reports_id,
                        typer: 'moveout',
                        mode: null,
                        auth_export_id: null,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        Swal.close();
                        if (res.status == 'success') {
                            $('.file-container').empty();
                            $('.file-container').append(
                                '<div class="col-12"></div><div class="col-12"><h5>檢測報告移出切結書</h5></div>');
                            res.contract_data.forEach(element => {
                                $('.file-container').append(
                                    '<div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">' +
                                    '<a href="' + window.location.origin + '/' + element
                                    .word + '" download>' +
                                    '<p class="text-secondary file-name" style="max-width: 200px;">' +
                                    element.affidavit_file_name + '</p>' +
                                    '<img src="{{ asset('assets/img/word-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                    '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                    '</a>' +
                                    '</div>' +
                                    '<div class="col-auto d-block pdf-download-content text-center mx-3">' +
                                    '<a href="' + window.location.origin + '/' + element
                                    .pdf + '" download>' +
                                    '<p class="text-secondary file-name" style="max-width: 200px;">' +
                                    element.affidavit_file_name + '</p>' +
                                    '<img src="{{ asset('assets/img/pdf-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                    '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                    '</a>' +
                                    '</div>');
                            });

                            $('.file-container').append(
                                '<div class="col-12"></div><div class="col-12 mt-3"><h5><檢測報告移出函文</h5></div>'
                            );
                            $('.file-container').append(
                                '<div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">' +
                                '<a href="' + window.location.origin + '/' + res.letter_data
                                .word + '" download>' +
                                '<p class="text-secondary file-name" style="max-width: 200px;">' + res
                                .letter_data.affidavit_letter_file_name + '</p>' +
                                '<img src="{{ asset('assets/img/word-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                '</a>' +
                                '</div>' +
                                '<div class="col-auto d-block pdf-download-content text-center mx-3">' +
                                '<a href="' + window.location.origin + '/' + res.letter_data
                                .pdf + '" download>' +
                                '<p class="text-secondary file-name" style="max-width: 200px;">' + res
                                .letter_data.affidavit_letter_file_name + '</p>' +
                                '<img src="{{ asset('assets/img/pdf-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                '</a>' +
                                '</div>');

                            $('.file-container').append(
                                '<div class="col-12"></div><div class="col-12 mt-3"><h5>移出清冊</h5></div>');
                            $('.file-container').append(
                                '<div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">' +
                                '<a href="' + window.location.origin + '/' + res.data_affidavit_data
                                .excel + '" download>' +
                                '<p class="text-secondary file-name" style="max-width: 200px;">' + res
                                .data_affidavit_data.data_affidavit_file_name + '</p>' +
                                '<img src="{{ asset('assets/img/excel-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                '</a>' +
                                '</div>');

                            setTimeout(function() {
                                $('#downloadModal').modal('show');
                            }, 500);
                        }

                    }
                })
            }

        }

        function postpone() {

            var reports_id = getReportsCheckboxForStatus('postpone');

            if (reports_id.length > 0) {
                // Swal.fire('注意！', '開發中！', 'warning');
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
                        data_ids: reports_id,
                        typer: 'postpone',
                        mode: null,
                        auth_export_id: null,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        Swal.close();
                        if (res.status == 'success') {
                            $('.file-container').empty();
                            $('.file-container').append(
                                '<div class="col-12"></div><div class="col-12"><h5>合約書</h5></div>');
                            res.contract_data.forEach(element => {
                                $('.file-container').append(
                                    '<div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">' +
                                    '<a href="' + window.location.origin + '/' + element
                                    .word + '" download>' +
                                    '<p class="text-secondary file-name" style="max-width: 200px;">' +
                                    element.postpone_contract_file_name + '</p>' +
                                    '<img src="{{ asset('assets/img/word-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                    '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                    '</a>' +
                                    '</div>' +
                                    '<div class="col-auto d-block pdf-download-content text-center mx-3">' +
                                    '<a href="' + window.location.origin + '/' + element
                                    .pdf + '" download>' +
                                    '<p class="text-secondary file-name" style="max-width: 200px;">' +
                                    element.postpone_contract_file_name + '</p>' +
                                    '<img src="{{ asset('assets/img/pdf-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                    '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                    '</a>' +
                                    '</div>');
                            });

                            $('.file-container').append(
                                '<div class="col-12"></div><div class="col-12 mt-3"><h5><申請函/h5></div>');
                            $('.file-container').append(
                                '<div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">' +
                                '<a href="' + window.location.origin + '/' + res.postpone_apply_letter_data
                                .word + '" download>' +
                                '<p class="text-secondary file-name" style="max-width: 200px;">' + res
                                .postpone_apply_letter_data.postpone_apply_letter_file_name + '</p>' +
                                '<img src="{{ asset('assets/img/word-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                '</a>' +
                                '</div>' +
                                '<div class="col-auto d-block pdf-download-content text-center mx-3">' +
                                '<a href="' + window.location.origin + '/' + res.postpone_apply_letter_data
                                .pdf + '" download>' +
                                '<p class="text-secondary file-name" style="max-width: 200px;">' + res
                                .postpone_apply_letter_data.postpone_apply_letter_file_name + '</p>' +
                                '<img src="{{ asset('assets/img/pdf-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                '</a>' +
                                '</div>');

                            $('.file-container').append(
                                '<div class="col-12"></div><div class="col-12 mt-3"><h5>登錄清冊</h5></div>');
                            $('.file-container').append(
                                '<div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">' +
                                '<a href="' + window.location.origin + '/' + res.data_postpone_data
                                .excel + '" download>' +
                                '<p class="text-secondary file-name" style="max-width: 200px;">' + res
                                .data_postpone_data.data_postpone_file_name + '</p>' +
                                '<img src="{{ asset('assets/img/excel-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                '</a>' +
                                '</div>');

                            setTimeout(function() {
                                $('#downloadModal').modal('show');
                            }, 500);
                        }

                    }
                })
            }

        }

        async function reply() {

            var reports_id = getReportsCheckboxForStatus('reply');

            if (reports_id.length > 0) {
                // Swal.fire('注意！', '開發中！', 'warning');

                const {
                    value: formValues
                } = await Swal.fire({
                    title: '請輸入回函文號',
                    html: '<input id="swal-input1" class="swal2-input">',
                    focusConfirm: false,
                    showCancelButton: true,
                    preConfirm: () => {
                        return document.getElementById('swal-input1').value
                    }
                })

                if (formValues) {
                    Swal.fire({
                        title: '處理中...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: "{{ route('admin.detectionReports.reply-modify') }}",
                        type: 'POST',
                        data: {
                            data_ids: reports_id,
                            reply_num: formValues,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            // Swal.close();
                            if (res.status == 'success') {
                                window.location.reload();
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire('錯誤！', '程序失敗', 'error');
                        }
                    });
                }
            }

        }
    </script>
@endpush
