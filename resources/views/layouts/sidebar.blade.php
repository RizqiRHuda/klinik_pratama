<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <div class="d-flex align-items-center">
                    <img src="{{ asset('img/logo_klinik.png') }}" style="width: 50px; height: auto; margin-right: 10px;" alt="logo">
                    <span class="fw-bold fs-6">Klinik Pratama</span>
                </div>
            </a>
        </div>
     
        <div class="navbar-content">
            <ul class="pc-navbar">
                @if (auth()->check() && auth()->user()->role == 'super_admin')
                <li class="pc-item">
                    <a href="{{ route('users.index') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Users Management</span>
                    </a>
                </li>
                @endif

                @if (auth()->check() && (auth()->user()->role == 'super_admin' || auth()->user()->role == 'admin'))
                <li class="pc-item">
                    <a href="{{ route('dashboard.' . auth()->user()->role) }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="{{ route('pasien.page-pasien') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-user-plus"></i> </span>
                        <span class="pc-mtext">Biodata</span>
                    </a>
                </li>

                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-vaccine"></i></span><span class="pc-mtext">Terapi</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="{{ route('terapi.page-terapi') }}">Form Terapi</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('terapi.table-terapi') }}">Table Riwayat</a></li>
                        <li class="pc-item"><a class="pc-link" href="{{ route('riwayat.page-riwayat') }}">Riwayat Personal</a></li>
                    </ul>
                </li>

                <li class="pc-item">
                    <a href="{{ route('obat.page-obat') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-bandage"></i> </span>
                        <span class="pc-mtext">Obat</span>
                    </a>
                </li>
                @endif
                @if (auth()->check() && auth()->user()->role == 'user')
                <li class="pc-item">
                    <a href="{{ route('dashboard.' . auth()->user()->role) }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('obat.page-obat') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-bandage"></i> </span>
                        <span class="pc-mtext">Obat</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>