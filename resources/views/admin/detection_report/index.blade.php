@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 justify-content-between">
                <div class="col-sm-auto">
                    <h1>檢測報告明細列表</h1>
                </div>
                <div class="col-sm-auto ">
                    <a class="btn btn-primary float-right" href="{{ route('admin.detectionReports.create') }}">
                        <i class="fas fa-plus"></i>
                        新增
                    </a>
                    <div class="float-right d-flex mr-2">
                        <div class="btn-action" id="btn-action">
                            <a class="btn btn-outline-success mr-2" id="btn-apply-delivery" href="javascript:void(0)"
                                onclick="applyForDelivery()">
                                申請送件
                            </a>
                            <a class="btn btn-outline-success mr-2" id="btn-apply-authorize" href="javascript:void(0)"
                                onclick="applyForAuthorize()">
                                開立授權
                            </a>
                            <a class="btn btn-outline-success mr-2" id="btn-move-out" href="javascript:void(0)"
                                onclick="moveOut()">
                                移出
                            </a>
                            <a class="btn btn-outline-success mr-2" id="btn-postpone" href="javascript:void(0)"
                                onclick="postpone()">
                                展延
                            </a>
                            <a class="btn btn-outline-success mr-2" id="btn-reply" href="javascript:void(0)"
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
        <div class="card">
            <div class="card-body">
                <div class="form-group form-check mb-3 py-1 d-flex align-items-center btn btn-outline-secondary"
                    style="width: max-content;">
                    <input type="checkbox" class="form-check-input check-all mr-1 my-0 ml-1 d-none"
                        style="width: 20px;height: 20px;" id="check-all" value="" />
                    <label for="check-all" class="check-all-label px-2 mb-0 ml-42">全選</label>
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
            $('.btn-action').hide();
            // $('#export-step-1').hide();
            $('#detectionReports-table tbody').on('change', 'input[name="reports[]"]', function() {
                var ck_reports = $('input[name="reports[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                if (ck_reports.length > 0) {
                    $('.btn-action').show(600);
                } else {
                    $('.btn-action').hide(600);
                    // $('#export-step-1').hide();
                }
            });

            $('#check-all').change(function() {
                if ($(this).is(':checked')) {
                    var rows = table.rows({
                        'page': 'current'
                    }).nodes();
                    $('.check-all-label').html('取消全選');
                    $('input[name="reports[]"]', rows).prop('checked', true);
                    $('input[name="reports[]"]', rows).change();
                } else {
                    $('.check-all-label').html('全選');
                    $('input[name="reports[]"]', rows).prop('checked', false);
                    $('input[name="reports[]"]', rows).change();
                }
            });

            var table = $('#detectionReports-table').DataTable({
                lengthChange: true, // 呈現選單
                lengthMenu: [10, 15, 20, 30, 50], // 選單值設定
                pageLength: 10, // 不用選單設定也可改用固定每頁列數

                searching: true, // 搜索功能
                ordering: true,
                // stateSave: true, // 保留狀態
                scrollCollapse: true,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.11.3/i18n/zh_Hant.json"
                },
                columnDefs: [{
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function(data, type, full, meta) {
                        var d = JSON.parse(data);
                        return '<input type="checkbox" name="reports[]"  style="width: 20px;height: 20px;" value="' +
                            $('<div/>').text(d.id).html() + '" data-letter="' + $('<div/>')
                            .text(d.letter_id).html() + '" data-status="' + $('<div/>').text(d
                                .reports_authorize_status).html() + '">';
                    }
                }],
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

        async function applyForAuthorize() {

            var reports_id = getReportsCheckboxForStatus('authorize');

            if (reports_id.length > 0) {
                // Swal.fire('注意！', '開發中！', 'warning');

                const {
                    value: formValues
                } = await Swal.fire({
                    title: '開立授權',
                    html: '<input id="swal-input1" class="swal2-input" placeholder="輸入授權公司" required="true">' +
                        '<input id="swal-input2" class="swal2-input" placeholder="輸入廠牌" required="true">' +
                        '<input id="swal-input3" class="swal2-input" placeholder="輸入車型" required="true">' +
                        '<input id="swal-input4" class="swal2-input" placeholder="輸入車身碼" required="true">',
                    focusConfirm: false,
                    showCancelButton: true,
                    preConfirm: () => {
                        if (document.getElementById('swal-input1').value != '' && document.getElementById('swal-input2').value != '' && document.getElementById(
                                'swal-input3').value != '' && document.getElementById('swal-input4')
                                .value != '') {

                            return [
                                document.getElementById('swal-input1').value,
                                document.getElementById('swal-input2').value,
                                document.getElementById('swal-input3').value,
                                document.getElementById('swal-input4').value
                            ];
                        } else {
                            Swal.showValidationMessage('輸入不能為空');
                        }
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
                        url: "{{ route('exportDocument') }}",
                        type: 'POST',
                        data: {
                            data_ids: reports_id,
                            typer: 'authorize',
                            auth_input: formValues,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.close();
                            if (res.status == 'success') {
                                $('.file-container').empty();
                                $('.file-container').append(
                                    '<div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">' +
                                    '<a href="' + window.location.origin + '/' + res.authorize_data
                                    .word + '" download>' +
                                    '<p class="text-secondary file-name" style="max-width: 200px;">' +
                                    res
                                    .authorize_data.authorize_file_name + '</p>' +
                                    '<img src="{{ asset('assets/img/word-icon.png') }}" class="img-fluid" width="80" alt="">' +
                                    '<p class="text-secondary font-weight-lighter">點擊即可下載</p>' +
                                    '</a>' +
                                    '</div>' +
                                    '<div class="col-auto d-block pdf-download-content text-center mx-3">' +
                                    '<a href="' + window.location.origin + '/' + res.authorize_data
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
                                    $('#downloadModal').on('hidden.bs.modal', function(event) {
                                        // do something...
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
                            Swal.fire('錯誤！', '程序失敗', 'error');
                        }
                    });
                }


            }

        }

        function moveOut() {

            var reports_id = getReportsCheckboxForStatus('moveout');

            if (reports_id.length > 0) {
                Swal.fire('注意！', '開發中！', 'warning');
            }

        }

        function postpone() {

            var reports_id = getReportsCheckboxForStatus('postpone');

            if (reports_id.length > 0) {
                Swal.fire('注意！', '開發中！', 'warning');
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
