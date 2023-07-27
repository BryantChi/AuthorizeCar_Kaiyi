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



