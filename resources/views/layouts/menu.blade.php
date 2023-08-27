<li class="nav-item">
    <a href="{{ route('admin.detectionReports.create') }}"
        class="nav-link">
        <p>新增檢測報告</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.detectionReports.index') }}"
        class="nav-link {{ Request::is('admin/detectionReports*') ? 'active' : '' }}">
        <p>檢測報告明細表</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.reporters.index') }}" class="nav-link {{ Request::is('admin/reporters*') ? 'active' : '' }}">
        <p>報告原有人管理</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.authorizeStatuses.index') }}"
        class="nav-link {{ Request::is('admin/authorizeStatuses*') ? 'active' : '' }}">
        <p>狀態項目管理</p>
    </a>
</li>


<li class="nav-item">
    <a href="{{ route('admin.regulations.index') }}"
        class="nav-link {{ Request::is('admin/regulations*') ? 'active' : '' }}">
        <p>法規項目管理</p>
    </a>
</li>


<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)" role="button"
        aria-expanded="false">
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
                <p>型號管理</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('admin.inspectionInstitutions.index') }}"
       class="nav-link {{ Request::is('admin/inspectionInstitutions*') ? 'active' : '' }}">
        <p>檢測機構管理</p>
    </a>
</li>

@push('menu_scripts')
    <script>
        $('.dropdown-menus').hide();
        $('.dropdown-toggle').click(function(){
            $('.dropdown-menus').toggle('1500');
        })

        var brand = "{{ Request::is('admin/carBrands*') }}";
        var model = "{{ Request::is('admin/carModels*') }}";
        if (brand || model) {
            $('.dropdown-menus').show();
        }

    </script>
@endpush
