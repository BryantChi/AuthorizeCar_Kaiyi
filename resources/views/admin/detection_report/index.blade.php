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
                        <a class="btn btn-outline-success mr-2" id="btn-apply-delivery" href="javascript:void(0)"
                            onclick="applyForDelivery()">
                            申請送件
                        </a>
                        <div class="dropdown" id="export-step-1">
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
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        @include('flash::message')
        <div class="card">
            <div class="card-body">
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
        <div class="modal-dialog modal-sm2 modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">檔案下載</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-auto d-block word-download-content text-center mx-3 mb-md-auto mb-3">
                            <a href="javascript:void(0)" download>
                                <img src="{{ asset('assets/img/word-icon.png') }}" class="img-fluid" width="80"
                                    alt="">
                                <p class="text-secondary font-weight-lighter">點擊即可下載</p>
                            </a>
                        </div>
                        <div class="col-auto d-block pdf-download-content text-center mx-3">
                            <a href="javascript:void(0)" download>
                                <img src="{{ asset('assets/img/pdf-icon.png') }}" class="img-fluid" width="80"
                                    alt="">
                                <p class="text-secondary font-weight-lighter">點擊即可下載</p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('page_scripts')
    <script>
        $(function() {
            $('#btn-apply-delivery').hide();
            $('#export-step-1').hide();
            $('input[name="reports[]"]').change(function() {
                var ck_reports = $('input[name="reports[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                if (ck_reports.length > 0) {
                    $('#btn-apply-delivery').show();
                } else {
                    $('#btn-apply-delivery').hide();
                }
            });

            // $('#btn-apply-delivery').click(function() {

            // })

            $('#check-all').change(function() {
                if ($(this).is(':checked')) {
                    $('.check-all-label').html('取消全選');
                    $('#detectionReports-table input[name="reports[]"]').prop('checked', true);
                    $('#detectionReports-table input[name="reports[]"]').change();
                } else {
                    $('.check-all-label').html('全選');
                    $('#detectionReports-table input[name="reports[]"]').prop('checked', false);
                    $('#detectionReports-table input[name="reports[]"]').change();
                }
            });

            $('#detectionReports-table').DataTable({
                lengthChange: true, // 呈現選單
                lengthMenu: [10, 15, 20, 30, 50], // 選單值設定
                pageLength: 10, // 不用選單設定也可改用固定每頁列數

                searching: true, // 搜索功能
                ordering: true,
                // stateSave: true, // 保留狀態
                scrollCollapse: true,
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.11.3/i18n/zh_Hant.json"
                }
            });
        });

        function getReportsCheckbox() {

            var checkReporter = $('input[name="reports[]"]:checked').map(function() {
                return $(this).data('reporter');
            }).get();

            if (checkReporter.length == 0) {
                Swal.fire('注意！', '請選擇至少一個項目！', 'warning');
                return [];
            } else {
                if (areAllValuesSame(checkReporter)) {
                    var ck = $('input[name="reports[]"]:checked').map(function() {
                        return $(this).val();
                    }).get();

                    return ck;
                } else {
                    Swal.fire('注意！', '報告原有人需相同！', 'warning');
                    return [];
                }
            }

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
            var reports_id = getReportsCheckbox();

            if (reports_id.length > 0) {
                $('#export-step-1').show();
            } else {
                $('#export-step-1').hide();
            }
        }

        function exportContract() {
            // console.log(getReportsCheckbox());

            var reports_id = getReportsCheckbox();

            if (reports_id.length > 0) {
                // $('#downloadModal').modal('show');

                $.ajax({
                    url: "{{ route('exportDocumentTest') }}",
                    type: 'POST',
                    data: {
                        data_ids: reports_id,
                        typer: 'move_in_contract',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        var report = JSON.parse(res);
                        // console.log(window.location.host + report.word);
                        if (report.status == 'success') {
                            $('.word-download-content>a').attr('href', window.location.origin + '/' + report
                                .word);
                            $('.word-download-content>a').prop('href', window.location.origin + '/' + report
                                .word);
                            $('.pdf-download-content>a').attr('href', window.location.origin + '/' + report
                            .pdf);
                            $('.pdf-download-content>a').prop('href', window.location.origin + '/' + report
                            .pdf);
                            setTimeout(function() {
                                $('#downloadModal').modal('show');
                                // window.open(window.location.origin + '/' + report.pdf);
                                // window.location.herf = "{{ route('convertToPdf', ['convert' => '" + report.word + "']) }}";
                            }, 500);
                        }

                    }
                })
            }

        }

        function exportInventory() {
            Swal.fire('注意！', '開發維護中！', 'warning');
        }

        function exportApplicationLetter() {
            Swal.fire('注意！', '開發維護中！', 'warning');
        }
    </script>
@endpush
