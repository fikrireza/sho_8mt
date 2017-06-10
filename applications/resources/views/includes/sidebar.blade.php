<div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="" class="site_title"> <span>BMT Ta'Awun</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile">
      <div class="profile_pic">
        {{-- <img src="{{ asset('images/avatar').'/'.Auth::user()->avatar}}" alt="..." class="img-circle profile_img"> --}}
      </div>
      <div class="profile_info">
        {{-- <span>Welcome, {{ Auth::user()->nama }}</span> --}}
        <h2></h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
          <li class="{{ Route::currentRouteNamed('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Beranda </a>
          </li>
          <li class="">
            <a>
              <i class="fa fa-beer"></i> Menu Transaksi <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu" style="">
              @if (session('status') == 'pbmt')
              <li class="">
                <a href="{{ route('daftar.index')}}">Daftar BMT</a>
              </li>
              @endif
              <li class="">
                <a href="{{ route('anggota.index') }}">Daftar Anggota</a>
              </li>
              <li class="">
                <a href="index.html">Daftar Peserta</a>
              </li>
              <li class="">
                <a href="index.html">Bayar Iuran</a>
              </li>
            </ul>
          </li>
          <li class="">
            <a>
              <i class="fa fa-desktop"></i> Menu Informasi <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu" style="">
              <li class="">
                <a href="index.html">Info Peserta</a>
              </li>
              <li class="">
                <a href="index.html">Info Tagihan</a>
              </li>
            </ul>
          </li>
          <li class="">
            <a href="index.html"><i class="fa fa-inbox"></i> Laporan </a>
          </li>
          <li class="">
            <a>
              <i class="fa fa-desktop"></i> Properti <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu" style="">
              <li class="">
                <a href="index.html">Data BMT</a>
              </li>
              <li class="">
                <a href="index.html">Data Rekening</a>
              </li>
              <li class="">
                <a href="index.html">Data Anggota</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
      <div class="menu_section">
        <h3>Extra</h3>
        <ul class="nav side-menu">
          <li class="">
            <a href="index.html"><i class="fa fa-inbox"></i> Akses Log </a>
          </li>
          <li class="">
            <a href="index.html"><i class="fa fa-users"></i> Users </a>
          </li>
        </ul>

      </div>
    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
      <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a href="{{ url('logout') }}" data-toggle="tooltip" data-placement="top" title="Logout">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>
    <!-- /menu footer buttons -->
  </div>
</div>
