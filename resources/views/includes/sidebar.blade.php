<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="" class="site_title"> <span>BMT Ta'Awun</span></a>
    </div>

    <div class="clearfix"></div>

    <div class="profile">
      <div class="profile_pic">
        <img src="{{ asset('images/avatar').'/'.Auth::user()->avatar}}" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Welcome, {{ Auth::user()->name }}</span>
        <h2></h2>
      </div>
    </div>

    <br />

    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
          <li class="{{ Route::is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}"><i class="fa fa-home"></i> Beranda </a>
          </li>
        </ul>
      </div>

      @if(Auth::user()->can('read-anggota') || Auth::user()->can('read-akad') || Auth::user()->can('read-pembayaran') || Auth::user()->can('read-klaim') || Auth::user()->can('read-laporan'))
      <div class="menu_section">
        <h3>Transaksi</h3>
        <ul class="nav side-menu">
          @can('read-anggota')
          <li class="{{ Route::is('anggota*') ? 'active' : '' }}">
            <a href="{{ route('anggota.index') }}"><i class="fa fa-edit"></i> Daftar Anggota</a>
          </li>
          @endcan
          @can('read-akad')
          <li class="{{ Route::is('akad*') ? 'current-page' : '' }}">
            <a href="{{ route('akad.index') }}"><i class="fa fa-edit"></i> Daftar Akad</a>
          </li>
          @endcan
          @can('read-pembayaran')
          <li class="{{ Route::is('iuran*') ? 'current-page' : '' }}">
            <a href="{{ route('iuran.index') }}"><i class="fa fa-edit"></i> Pembayaran Iuran</a>
          </li>
          @endcan
          @can('read-klaim')
          <li class="{{ Route::is('klaim*') ? 'current-page' : '' }}">
            <a href="{{ route('klaim.index') }}"><i class="fa fa-edit"></i> Klaim</a>
          </li>
          @endcan
          @can ('read-jurnal')
          <li class="{{ Route::is('jurnal*') ? 'current-page' : '' }}">
            <a href="{{ route('jurnal.index') }}"><i class="fa fa-edit"></i> Jurnal</a>
          </li>
          @endcan
          @can('read-laporan')
          <li class="{{ Route::is('laporan*') ? 'current-page' : '' }}">
            <a href="{{ route('laporan.index') }}"><i class="fa fa-edit"></i> Laporan </a>
          </li>
          @endcan
        </ul>
      </div>
      @endif

      @if (Auth::user()->can('read-bidang') || Auth::user()->can('read-daftar') || Auth::user()->can('read-posisi') || Auth::user()->can('read-plafon'))
      <div class="menu_section">
        <h3>Master</h3>
        <ul class="nav side-menu">
          @can('read-daftar')
          <li class="{{ Route::is('daftar*') ? 'current-page' : '' }}">
            <a href="{{ route('daftar.index') }}"><i class="fa fa-inbox"></i> Daftar BMT </a>
          </li>
          @endcan
          @can('read-bidang')
          <li class="{{ Route::is('bidang*') ? 'current-page' : '' }}">
            <a href="{{ route('bidang.index') }}"><i class="fa fa-inbox"></i> Bidang</a>
          </li>
          @endcan
          @can('read-posisi')
          <li class="{{ Route::is('posisi*') ? 'current-page' : '' }}">
            <a href="{{ route('posisi.index') }}"><i class="fa fa-inbox"></i> Posisi</a>
          </li>
          @endcan
          @can('read-plafon')
          <li class="{{ Route::is('plafon*') ? 'active' : '' }}">
            <a>
              <i class="fa fa-inbox"></i> Plafon <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu" style="{{ Route::is('plafon*') ? 'display: block;' : '' }}">
              <li class="{{ Route::is('plafon.jiwa*') ? 'sub_menu' : '' }}">
                <a href="{{ route('plafon.jiwa') }}">Jiwa</a>
              </li>
              <li class="{{ Route::is('plafon.kebakaran*') ? 'sub_menu' : '' }}">
                <a href="{{ route('plafon.kebakaran') }}">Kebakaran</a>
              </li>
              <li class="{{ Route::is('plafon.template') ? 'sub_menu' : ''}}">
                <a href="{{ route('plafon.template') }}">Upload</a>
              </li>
            </ul>
          </li>
          @endcan
        </ul>
      </div>
      @endif

      @can('management-user')
      <div class="menu_section">
        <h3>Extra</h3>
        <ul class="nav side-menu">
          @can ('read-logakses')
          <li class="">
            <a href="{{ route('logakses.index') }}"><i class="fa fa-area-chart"></i> Akses Log </a>
          </li>
          @endcan
          <li class="{{ Route::is('account.*') ? 'active' : '' }}">
            <a>
              <i class="fa fa-users"></i> Manage User <span class="fa fa-chevron-down"></span>
            </a>
            <ul class="nav child_menu" style="{{ Route::is('account.*') ? 'display: block;' : '' }}">
              @can ('read-user')
              <li class="{{ Route::is('account.user*') ? 'current-page' : '' }}">
                <a href="{{ route('account.userIndex') }}">User</a>
              </li>
              @endcan
              @can ('read-role')
              <li class="{{ Route::is('account.role*') ? 'current-page' : '' }}">
                <a href="{{ route('account.roleIndex') }}">Role</a>
              </li>
              @endcan
            </ul>
          </li>
        </ul>
      </div>
      @endcan

    </div>

    <div class="sidebar-footer hidden-small">
      <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a href="{{ url('logout') }}" data-toggle="tooltip" data-placement="top" title="Logout">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a>
    </div>
  </div>
</div>
