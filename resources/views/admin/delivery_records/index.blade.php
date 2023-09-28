@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>申請送件紀錄</h1>
                </div>
                {{-- <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('admin.deliveryRecords.create') }}">
                        Add New
                    </a>
                </div> --}}
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                @include('admin.delivery_records.table')

                {{-- <div class="card-footer clearfix">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $deliveryRecords])
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
            let scrollX_enable = false;
            if($(window).width() > 1200) { scrollX_enable = false }
            else { scrollX_enable = true }

            var table = $('#deliveryRecords-table').DataTable({
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
                        $('#reports_expiration_date_end').html(res.data.reports_expiration_date_end);
                        $('#reports_reporter').html(res.data.reports_reporter);
                        $('#reports_car_brand').html(res.data.reports_car_brand);
                        $('#reports_car_model').html(res.data.reports_car_model);
                        $('#reports_inspection_institution').html(res.data.reports_inspection_institution);
                        $('#reports_regulations').html(res.data.reports_regulations);
                        $('#reports_car_model_code').html(res.data.reports_car_model_code);
                        $('#reports_test_date').html(res.data.reports_test_date);
                        $('#reports_date').html(res.data.reports_date);
                        $('#reports_vin').html(res.data.reports_vin);
                        $('#reports_authorize_count_before').html(res.data.reports_authorize_count_before);
                        $('#reports_authorize_count_current').html(res.data.reports_authorize_count_current);
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
