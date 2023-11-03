<div class="row">
    <h2 class="text-center mb-5 w-100">開立授權</h2>
    <div class="col-md-3 p-3">
        <div class="form-group">
            <label for="inp_com">授權使用對象</label>
            <input type="text" class="form-control" id="inp_com" placeholder="輸入授權使用對象">
        </div>
        <div class="form-group">
            <label class="font-weight-bold" for="car_brand">廠牌</label>
            <select class="form-control custom-select bg-white" name="car_brand" id="car_brand">
                <option value="">請選擇</option>
                @foreach ($brand ?? [] as $item)
                    <option value="{{ $item->id }}">{{ $item->brand_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group d-block">
            <label class="font-weight-bold" for="car_model">型號</label>
            <select class="form-control custom-select2 bg-white2 w-100" name="car_model" id="car_model">
                <option value="">請選擇</option>
            </select>
        </div>
        <div class="form-group">
            <label for="inp_vin">車身碼</label>
            <input type="text" class="form-control" id="inp_vin" placeholder="輸入車身碼">
        </div>
        <div class="form-group">
            <label for="inp_auth_num">授權書編號</label>
            <input type="text" class="form-control" id="inp_auth_num" placeholder="輸入授權書編號">
        </div>
    </div>
    <div class="col-md-9 p-3 authorize-temp-conatiner">
        <div class="form-row justify-content-center">
            <div class="form-group col-md-3 col-6">
                <label class="font-weight-bold" for="reports_regulations">法規項目</label>
                <select class="form-control custom-select bg-white" name="reports_regulations[]"
                    id="reports_regulations" multiple="multiple" placeholder="請選擇">
                    <option value="">請選擇</option>
                    @foreach ($regulations ?? [] as $item)
                        <option
                            {{ in_array($item->regulations_num, $detectionReport->reports_regulations ?? []) ? ' selected="selected"' : '' }}
                            value="{{ $item->regulations_num }}">
                            {{ $item->regulations_num . ' ' . $item->regulations_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3 col-6">
                <label for="reports_num">檢測報告編號</label>
                <select id="reports_num" class="form-control">
                </select>
            </div>
            <div class="form-group col-md-4 col-6">
                <label for="inputAuthNum">授權使用序號</label>
                <input type="text" class="form-control" id="inputAuthNum" disabled>
            </div>
            <div class="form-group col-auto justify-content-center pt-4 mt-2">
                <button class="btn btn-info mx-auto" id="addAuth">加入</button>
            </div>
        </div>
        <div style="border-bottom: 1px dashed #444444bf"></div>
        <div class="table-responsive" style="height: 23rem;overflow-y: auto;">
            <table class="table table-hover" id="authorize-data-temp-table">
                <thead>
                    <tr>
                        <th>檢測基準項目</th>
                        <th>檢測報告編號</th>
                        <th>授權使用序號</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center mt-3">
        <button type="button" class="btn btn-primary mr-2" id="btn-auth">開立</button>
        <button type="button" class="btn btn-secondary btn-auth-cancel">取消</button>
    </div>
</div>


{{-- <div class="modal fade" id="authorizationModal" tabindex="-1" aria-labelledby="authorizationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    <h3 class="modal-title text-center" id="authorizationModalLabel">開立授權</h3>

                    <div class="p-3">
                        <div class="form-group">
                            <label for="inp_com">授權公司</label>
                            <input type="text" class="form-control" id="inp_com" placeholder="輸入授權公司">
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="car_brand">廠牌</label>
                            <select class="form-control custom-select bg-white" name="car_brand" id="car_brand">
                                <option value="">請選擇</option>
                                @foreach ($brand as $item)
                                    <option value="{{ $item->id }}">{{ $item->brand_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-block">
                            <label class="font-weight-bold" for="car_model">型號</label>
                            <select class="form-control custom-select2 bg-white2 w-100" name="car_model" id="car_model">
                                <option value="">請選擇</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inp_vin">車身碼</label>
                            <input type="text" class="form-control" id="inp_vin" placeholder="輸入車身碼">
                        </div>
                        <div class="form-group">
                            <label for="inp_auth_num">授權書編號</label>
                            <input type="text" class="form-control" id="inp_auth_num" placeholder="輸入授權書編號">
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" id="btn-auth">開立</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div> --}}
