<li class="nav-item">
    <a href="{{ route('admin.detectionReports.index') }}"
        class="nav-link {{ Request::is('admin/detectionReports*') ? 'active' : '' }}">
        <p style="font-size: 1.15rem;">檢測報告總表</p>
    </a>
</li>

<li class="nav-item mt-4">
    <a href="{{ route('admin.detectionReports.create') }}" class="nav-link">
        <p style="font-size: 1.15rem;">新增檢測報告</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.detectionReports.index') }}?auth_apply=on" class="nav-link">
        <p  style="font-size: 1.15rem;">開立授權</p>
    </a>
</li>


<li class="nav-item mt-4">
    <a class="nav-link dropdown-toggle dropdown-system-action" data-toggle="dropdown" href="javascript:void(0)"
        role="button" aria-expanded="false">
        <p class="h5">系統操作</p>
    </a>
    <ul class="dropdown-menus nav nav-pills ml-3">
        <li class="nav-item">
            <a href="{{ route('admin.exportAuthorizeRecords.index') }}"
                class="nav-link {{ Request::is('admin/exportAuthorizeRecords*') ? 'active' : '' }}">
                <p>授權開立紀錄(複製/修改)</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item mt-4">
    <a class="nav-link dropdown-toggle dropdown-record" data-toggle="dropdown" href="javascript:void(0)" role="button"
        aria-expanded="false">
        <p class="h5">匯出報表</p>
    </a>
    <ul class="dropdown-menus nav nav-pills ml-3">
        <li class="nav-item">
            <a href="{{ route('admin.deliveryRecords.index') }}"
                class="nav-link {{ Request::is('admin/deliveryRecords*') ? 'active' : '' }}">
                <p>送件紀錄</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.agreeAuthorizeRecords.index') }}"
                class="nav-link {{ Request::is('admin/agreeAuthorizeRecords*') ? 'active' : '' }}">
                <p>授權書記錄</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.cumulativeAuthorizedUsageRecords.index') }}"
                class="nav-link {{ Request::is('admin/cumulativeAuthorizedUsageRecords*') ? 'active' : '' }}">
                <p>授權次數明細紀錄</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.affidavitRecords.index') }}"
                class="nav-link {{ Request::is('admin/affidavitRecords*') ? 'active' : '' }}">
                <p>移出紀錄</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.postponeRecords.index') }}"
                class="nav-link {{ Request::is('admin/postponeRecords*') ? 'active' : '' }}">
                <p>展延紀錄</p>
            </a>
        </li>
    </ul>
</li>


<li class="nav-item mt-4">
    <a class="nav-link dropdown-toggle dropdown-dbdata" data-toggle="dropdown" href="javascript:void(0)" role="button"
        aria-expanded="false">
        <p class="h5">資料庫</p>
    </a>
    <ul class="dropdown-menus nav nav-pills ml-3">
        <li class="nav-item">
            <a href="{{ route('admin.reporters.index') }}"
                class="nav-link {{ Request::is('admin/reporters*') ? 'active' : '' }}">
                <p>報告原有人</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.authorizeStatuses.index') }}"
                class="nav-link {{ Request::is('admin/authorizeStatuses*') ? 'active' : '' }}">
                <p>狀態管理</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.regulations.index') }}"
                class="nav-link {{ Request::is('admin/regulations*') ? 'active' : '' }}">
                <p>法規項目</p>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle dropdown-car" data-toggle="dropdown" href="javascript:void(0)"
                role="button" aria-expanded="false">
                <p>車型管理</p>
            </a>
            <ul class="dropdown-menus nav nav-pills ml-3">
                <li class="nav-item">
                    <a href="{{ route('admin.carBrands.index') }}"
                        class="nav-link {{ Request::is('admin/carBrands*') ? 'active' : '' }}">
                        <p>廠牌管理</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.carModels.index') }}"
                        class="nav-link {{ Request::is('admin/carModels*') ? 'active' : '' }}">
                        <p>型式管理</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.carPatterns.index') }}"
               class="nav-link {{ Request::is('admin/carPatterns*') ? 'active' : '' }}">
                <p>車輛樣式管理</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.carFuelCategories.index') }}"
               class="nav-link {{ Request::is('admin/carFuelCategories*') ? 'active' : '' }}">
                <p>燃油類別管理</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.inspectionInstitutions.index') }}"
                class="nav-link {{ Request::is('admin/inspectionInstitutions*') ? 'active' : '' }}">
                <p>檢測機構管理</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.companyInfos.index') }}"
                class="nav-link {{ Request::is('admin/companyInfos*') ? 'active' : '' }}">
                <p>公司資訊</p>
            </a>
        </li>
    </ul>
</li>

@push('menu_scripts')
    <script>
        $(function() {
            $('.dropdown-menus').hide();

            $('.dropdown-toggle').each(function() {
                $(this).click(function() {
                    $(this).parent().find('.dropdown-menus').first().toggle('1500');
                });

            });

            // let detectionReports = "{{ Request::is('admin/detectionReports*') }}";
            // if (detectionReports) {
            //     $('.dropdown-menus').hide();
            // }

            let brand = "{{ Request::is('admin/carBrands*') }}";
            let model = "{{ Request::is('admin/carModels*') }}";
            if (brand || model) {
                $('.dropdown-car').parent().find('.dropdown-menus').show();
                $('.dropdown-car').parent().parent().show();
            }

            let system_action = "{{ Request::is('admin/exportAuthorizeRecords*') }}";
            if (system_action) {
                $('.dropdown-system-action').parent().find('.dropdown-menus').show();
            }

            let delivery = "{{ Request::is('admin/deliveryRecords*') }}";
            let agreeAuth = "{{ Request::is('admin/agreeAuthorizeRecords*') }}";
            let cumulative = "{{ Request::is('admin/cumulativeAuthorizedUsageRecords*') }}";
            let affidavit = "{{ Request::is('admin/affidavitRecords*') }}";
            let postpone = "{{ Request::is('admin/postponeRecords*') }}";
            if (delivery || agreeAuth || cumulative || affidavit || postpone) {
                $('.dropdown-record').parent().find('.dropdown-menus').show();
            }

            let reporters = "{{ Request::is('admin/reporters*') }}";
            let authorizeStatuses = "{{ Request::is('admin/authorizeStatuses*') }}";
            let regulations = "{{ Request::is('admin/regulations*') }}";
            let inspectionInstitutions = "{{ Request::is('admin/inspectionInstitutions*') }}";
            let companyInfos = "{{ Request::is('admin/companyInfos*') }}";
            let carPatterns = "{{ Request::is('admin/carPatterns*') }}";
            let carFuelCategories = "{{ Request::is('admin/carFuelCategories*') }}";
            if (reporters || authorizeStatuses || regulations || inspectionInstitutions || companyInfos || carPatterns || carFuelCategories) {
                $('.dropdown-dbdata').parent().find('.dropdown-menus').show();
            }
        });
    </script>
@endpush
