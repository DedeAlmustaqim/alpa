<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Aplikasi Layanan Aset Kabupaten Barito Timur">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset(url('/') . $config->logo) }}">
    <!-- Page Title  -->
    <title>{{ $title }}</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset('admin/src/assets/css/dashlite.css?ver=3.2.3') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset('admin/src/assets/css/theme.css?ver=3.2.3') }}">
    <link rel="stylesheet" href="{{ asset('admin/src/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
</head>

<body class="nk-body bg-lighter npc-general has-sidebar ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <div class="nk-sidebar nk-sidebar-fixed is-dark " data-content="sidebarMenu">
                <div class="nk-sidebar-element nk-sidebar-head">
                    <div class="nk-menu-trigger">
                        <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none"
                            data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                        <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex"
                            data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                    </div>
                    <div class="nk-sidebar-brand">
                        <a href="html/index.html" class="logo-link nk-sidebar-logo">
                            <img class="logo-light logo-img" src="{{ asset(url('/') . $config->logo) }}" alt="logo">
                            <img class="logo-dark logo-img" src="{{ asset(url('/') . $config->logo) }}" alt="logo-dark">
                        </a>
                    </div>
                </div><!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element nk-sidebar-body">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">

                                <li class="nk-menu-item">
                                    <a href="{{ url('/admin/dashboard') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-home-fill"></em></span>
                                        <span class="nk-menu-text">Dashboard</span>
                                    </a>
                                </li><!-- .nk-menu-item -->

                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">Kelola Aset</h6>
                                </li><!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-inbox-fill"></em></span>
                                        <span class="nk-menu-text">Aset</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ url('/admin/aset') }}" class="nk-menu-link"><span
                                                    class="nk-menu-text">Daftar Aset</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ url('/admin/aset-pinjam') }}" class="nk-menu-link"><span
                                                    class="nk-menu-text">Aset dipinjam</span></a>
                                        </li>

                                    </ul><!-- .nk-menu-sub -->
                                </li>
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle">
                                        <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                        <span class="nk-menu-text">Permohonan</span>
                                    </a>
                                    <ul class="nk-menu-sub">
                                        <li class="nk-menu-item">
                                            <a href="{{ url('/admin/permohonan') }}" class="nk-menu-link"><span
                                                    class="nk-menu-text">Sedang dimohon</span></a>
                                        </li>
                                        @if (auth()->user()->role === 'verifikator')
                                        <li class="nk-menu-item">
                                            <a href="{{ url('/admin/permohonan-verif') }}" class="nk-menu-link"><span
                                                    class="nk-menu-text">Verifikasi Permohonan</span></a>
                                        </li>
                                        @endif
                                        <li class="nk-menu-item">
                                            <a href="{{ url('/admin/permohonan-finish') }}" class="nk-menu-link"><span
                                                    class="nk-menu-text">Permohonan Selesai</span></a>
                                        </li>
                                        <li class="nk-menu-item">
                                            <a href="{{ url('/admin/permohonan-reject') }}" class="nk-menu-link"><span
                                                    class="nk-menu-text">Permohonan Ditolak</span></a>
                                        </li>

                                    </ul><!-- .nk-menu-sub -->
                                </li>
                                @if (auth()->user()->role === 'admin')
                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">Referensi</h6>
                                    </li><!-- .nk-menu-item -->

                                    <li class="nk-menu-item has-sub">
                                        <a href="javascript:void(0)" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-user-fill"></em></span>
                                            <span class="nk-menu-text">Pengguna</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item">
                                                <a href="{{ url('/admin/admin-opd') }}" class="nk-menu-link"><span
                                                        class="nk-menu-text">Admin OPD</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="{{ url('/admin/user') }}" class="nk-menu-link"><span
                                                        class="nk-menu-text">User</span></a>
                                            </li>

                                        </ul><!-- .nk-menu-sub -->
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="{{ url('/admin/opd') }}" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em
                                                    class="icon ni ni-building"></em></em></span>
                                            <span class="nk-menu-text">OPD</span>
                                        </a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="{{ url('/admin/kategori') }}" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-list-fill "></em></span>
                                            <span class="nk-menu-text">Kategori</span>
                                        </a>
                                    </li>

                                    <li class="nk-menu-item has-sub">
                                        <a href="javascript:void(0)" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em
                                                    class="icon ni ni-setting-fill"></em></span>
                                            <span class="nk-menu-text">Pengaturan</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item">
                                                <a href="{{ url('/admin/app') }}" class="nk-menu-link"><span
                                                        class="nk-menu-text">Aplikasi</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="{{ url('/admin/pass-reset') }}" class="nk-menu-link"><span
                                                        class="nk-menu-text">Ubah Password</span></a>
                                            </li>

                                        </ul><!-- .nk-menu-sub -->
                                    </li>
                                @endif

                                @if (auth()->user()->role === 'opd')
                                    <li class="nk-menu-item has-sub">
                                        <a href="javascript:void(0)" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em
                                                    class="icon ni ni-setting-fill"></em></span>
                                            <span class="nk-menu-text">Pengaturan</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item">
                                                <a href="{{ url('/opd/profil') }}" class="nk-menu-link"><span
                                                        class="nk-menu-text">Profil</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="{{ url('/admin/pass-reset') }}" class="nk-menu-link"><span
                                                        class="nk-menu-text">Ubah Password</span></a>
                                            </li>

                                        </ul><!-- .nk-menu-sub -->
                                    </li>
                                @endif
                                <li class="nk-menu-item">
                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>


                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        class="nk-menu-link"><span class="nk-menu-icon"><em
                                                class="icon ni ni-signout"></em></span>
                                        <span class="nk-menu-text">Logout</span></a>
                                </li><!-- .nk-menu-item -->

                            </ul><!-- .nk-menu -->
                        </div><!-- .nk-sidebar-menu -->
                    </div><!-- .nk-sidebar-content -->
                </div><!-- .nk-sidebar-element -->
            </div>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed is-light">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">

                            <h5> {{ $config->app_name }}</h5>
                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">

                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                                <div class="user-info d-none d-md-block">
                                                    <div class="user-status">{{ session('role') }}</div>
                                                    <div class="user-name dropdown-indicator">{{ session('name') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end dropdown-menu-s1">


                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <li>
                                                        <form id="logout-form" action="{{ url('/logout') }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                        </form>

                                                        <a href="#"
                                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                            <em class="icon ni ni-signout"></em>
                                                            <span>Sign out</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li><!-- .dropdown -->

                                </ul><!-- .nk-quick-nav -->
                            </div><!-- .nk-header-tools -->
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <!-- footer @s -->
                <div class="nk-footer">
                    <div class="container-fluid">
                        <div class="nk-footer-wrap">
                            <div class="nk-footer-copyright"> &copy; Sekretariat Daerah
                            </div>
                            <div class="nk-footer-links">
                                <ul class="nav nav-sm">


                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- select region modal -->

    <!-- JavaScript -->
    <script src="{{ asset('admin/src/app.js') }}?v={{ \Carbon\Carbon::now()->timestamp }}"></script>

    <script src="{{ asset('admin/src/assets/js/bundle.js?ver=3.2.3') }}"></script>
    <script src="{{ asset('admin/src/assets/js/scripts.js?ver=3.2.3') }}"></script>
    <script src="{{ asset('admin/src/assets/js/libs/datatable-btns.js?ver=3.2.3') }}"></script>


    <script>
        var BASE_URL = "{{ url('/') }}";
        var userRole = "{{ session('role') }}";
        $(document).ready(function() {
            $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
                return {
                    "iStart": oSettings._iDisplayStart,
                    "iEnd": oSettings.fnDisplayEnd(),
                    "iLength": oSettings._iDisplayLength,
                    "iTotal": oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                    "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                };
            };
        })
    </script>
    @stack('scripts')

</body>

</html>
