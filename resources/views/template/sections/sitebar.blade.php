<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo mb-3">
        <a href="{{ route('dashboard.' . Auth::user()->role) }}" class="app-brand-link">
            <img src="https://pbs.twimg.com/profile_images/1412455876363882503/YhpAFz-x_400x400.jpg" alt=""
                height="60">
            <span class="app-brand-text demo menu-text fw-bolder ms-2">E-Voting</span>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::is('admin/dashboard*') || Request::is('siswa/dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard.' . Auth::user()->role) }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Management Data</span>
        </li>
        @if (Auth::user()->role == 'admin')
            <li class="menu-item {{ Request::is('admin/kandidat*') ? 'active' : '' }}">
                <a href="{{ route('admin.kandidat.store') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-user-detail"></i>
                    <div data-i18n="Data Kandidat">Data Kandidat</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('admin/data-pemilih*') ? 'active' : '' }}">
                <a href="{{ route('admin.data-pemilih.store') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
                    <div data-i18n="Result Voting Data">Result Voting Data</div>
                </a>
            </li>
        @endif
        <!-- Components -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Management User</span>
        </li>
        <!-- Cards -->
        <li class="menu-item">
            <a href="" class="menu-link {{ Request::is('admin/user*') ? 'active' : '' }}">
                <i class="menu-icon tf-icons bx bxs-user-account"></i>
                <div data-i18n="List Data User">List Data User</div>
            </a>
        </li>
    </ul>
</aside>
