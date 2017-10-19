@extends('layout.master')

@section('title')
  <title>BMT Ta'Awun | Dashboard</title>
@endsection

@section('content')

<div class="row tile_count">
  @if (Auth::user()->id_bmt == null)
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-building"></i> Jumlah BMT</span>
    <div class="count">{{ $getBmt->count() }}</div>
    <span class="count_bottom"><i><a href="{{ route('daftar.index')}}">Daftar BMT</a></i></span>
  </div>
  @endif
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-user"></i> Jumlah Anggota</span>
    <div class="count">{{ $getAnggota->count() }}</div>
    <span class="count_bottom"><i><a href="{{ route('anggota.index')}}">Kelola Anggota</a></i></span>
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-clock-o"></i> Jumlah Akad</span>
    <div class="count">{{ $getAkad->count() }}</div>
    <span class="count_bottom"><i><a href="{{ route('akad.index') }}">Kelola Akad</a></i></span>
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-money"></i> Jumlah Iuran</span>
    <div class="count green">{{ $getIuran->count() }}</div>
    <span class="count_bottom"><i class="green">Rp. {{ number_format($getIuran->sum('nilai_iuran'),0,'.','.') }},-</i></span>
  </div>
  <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
    <span class="count_top"><i class="fa fa-refresh"></i> Jumlah Klaim</span>
    <div class="count red">{{ $getKlaim->count() }}</div>
    <span class="count_bottom"><i class="red">Rp. {{ number_format($getKlaim->sum('total_bayar'),0,'.','.')}},-</i></span>
  </div>
</div>


<div class="row">

  @can ('read-anggota')
  <div class="col-md-3 col-sm-3 col-xs-12 red">
    <div class="x_panel">
      <div class="x_title">
        <h2>Modul Anggota</h2>
        <div class="nav panel_toolbox">
          @can ('create-anggota')
          <a href="{{ route('anggota.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
          @endcan
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          <ul class="list-unstyled timeline widget">
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Daftar Anggota</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Terdapat list anggota berdasarkan BMT yang terdaftar.
                  </p>
                </div>
              </div>
            </li>
            @can('create-anggota')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Tambah Anggota</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Tambah Anggota adalah fitur untuk menambahkan data anggota berdasarkan BMT.
                  </p>
                </div>
              </div>
            </li>
            @endcan
            @can ('update-anggota')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Ubah Anggota</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Ubah Anggota adalah fitur untuk mengubah data anggota yang terdapat di BMT.
                  </p>
                </div>
              </div>
            </li>
            @endcan
          </ul>
        </div>
      </div>
    </div>
  </div>
  @endcan

  @can ('read-akad')
  <div class="col-md-3 col-sm-3 col-xs-12 red">
    <div class="x_panel">
      <div class="x_title">
        <h2>Modul Akad</h2>
        <div class="nav panel_toolbox">
          @can ('create-akad')
          <a href="{{ route('akad.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
          @endcan
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          <ul class="list-unstyled timeline widget">
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Daftar Akad</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Status Akad Terdiri dari:<br>
                    <ul>
                      <li><b>Lunas</b> : Akad yang iurannya sudah Lunas.</li>
                      <li><b>Klaim</b> : Akad yang sudah diklaim.</li>
                      <li><b>Batal</b> : Akad yang dibatalkan karena alasan tertentu.</li>
                      <li><b>Belum Disetujui</b> : Akad yang belum disetujui.</li>
                      <li><b>Disetujui</b> : Akad yang sudah disetujui oleh admin BMT.</li>
                    </ul>
                  </p>
                </div>
              </div>
            </li>
            @can('create-akad')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Tambah Akad</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Tambah Akad adalah fitur untuk menambahkan data akad. Akad akan bisa ditambahkan bagi anggota yang sudah melunasi akad sebelumnya dan atau yang belum mempunyai akad.
                  </p>
                </div>
              </div>
            </li>
            @endcan
            @can('approve-akad')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Lihat Akad</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Lihat Akad adalah fitur yang digunakan untuk mengubah status akad.
                  </p>
                </div>
              </div>
            </li>
            @endcan
          </ul>
        </div>
      </div>
    </div>
  </div>
  @endcan

  @can ('read-pembayaran')
  <div class="col-md-3 col-sm-3 col-xs-12 red">
    <div class="x_panel">
      <div class="x_title">
        <h2>Pembayaran Iuran</h2>
        <div class="nav panel_toolbox">
          @can ('create-pembayaran')
          <a href="{{ route('iuran.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
          @endcan
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          <ul class="list-unstyled timeline widget">
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Pembayaran Iuran</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Terdapat list pembayaran iuran berdasarkan akad.<br>
                    Dapat difilter berdasarkan tahun.
                  </p>
                </div>
              </div>
            </li>
            @can('create-pembayaran')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Tambah Pembayaran Iuran</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Tambah Pembayaran Iuran adalah fitur untuk menambahkan data pembayaran iuran berdasarkan akad yang telah disetujui.<br>
                    Terdapat fitur upload bukti transfer jika pembayaran untuk jenis "TRANSFER".
                  </p>
                </div>
              </div>
            </li>
            @endcan
            @can('delete-pembayaran')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Hapus Pembayaran Iuran</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Hapus Pembayaran Iuran adalah fitur yang digunakan untuk menghapus iruan, dan data pada jurnal juga akan terhapus.<br>
                    Harap periksa kembali sebelum menghapus iuran.
                  </p>
                </div>
              </div>
            </li>
            @endcan
          </ul>
        </div>
      </div>
    </div>
  </div>
  @endcan

  @can ('read-klaim')
  <div class="col-md-3 col-sm-3 col-xs-12 red">
    <div class="x_panel">
      <div class="x_title">
        <h2>Klaim</h2>
        <div class="nav panel_toolbox">
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          <ul class="list-unstyled timeline widget">
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Cek Klaim</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Terdapat list akad yang sudah disetujui.<br>
                    Dalam Histori Iuran, dapat dilihat akad, tanggal iuran beserta jumlahya.
                  </p>
                </div>
              </div>
            </li>
            @can('create-klaim')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Proses Klaim</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Fitur ini untuk memproses klaim.<br>
                    Untuk Akad yang sudah diproses klaim, status akad akan berubah menjadi "KLAIM" dan Jurnal pun akan diupdate.
                  </p>
                </div>
              </div>
            </li>
            @endcan
          </ul>
        </div>
      </div>
    </div>
  </div>
  @endcan

  @can ('read-jurnal')
  <div class="col-md-3 col-sm-3 col-xs-12 red">
    <div class="x_panel">
      <div class="x_title">
        <h2>Jurnal</h2>
        <div class="nav panel_toolbox">
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          <ul class="list-unstyled timeline widget">
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Jurnal</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Terdapat filter BMT dan Bulan.<br>
                  </p>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  @endcan
</div>

<div class="row">

  @can ('read-daftar')
  <div class="col-md-3 col-sm-3 col-xs-12 blue">
    <div class="x_panel">
      <div class="x_title">
        <h2>Daftar BMT</h2>
        <div class="nav panel_toolbox">
          @can ('create-daftar')
          <a href="{{ route('daftar.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
          @endcan
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          <ul class="list-unstyled timeline widget">
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Daftar Akad</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Terdapat list BMT yang sudah terdaftar.
                  </p>
                </div>
              </div>
            </li>
            @can('create-daftar')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Tambah BMT</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Tambah BMT adalah fitur untuk menambahkan data BMT dan sekaligus menambahkan data anggota. Jadi dimana ada BMT baru maka akan terbentuk data anggota baru. Data anggota ini juga akan menjadi akun untuk mengakses website BMT dengan bantuan tambahan dari <b>Administrator Web</b>.
                  </p>
                </div>
              </div>
            </li>
            @endcan
            @can('update-daftar')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Ubah BMT</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Ubah BMT adalah fitur yang digunakan untuk mengubah data BMT saja.
                  </p>
                </div>
              </div>
            </li>
            @endcan
          </ul>
        </div>
      </div>
    </div>
  </div>
  @endcan

  @can ('read-bidang')
  <div class="col-md-3 col-sm-3 col-xs-12 blue">
    <div class="x_panel">
      <div class="x_title">
        <h2>Bidang</h2>
        <div class="nav panel_toolbox">
          @can ('create-bidang')
          <a href="{{ route('bidang.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
          @endcan
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          <ul class="list-unstyled timeline widget">
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Bidang</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Terdapat list bidang yang sudah terdaftar.<br>
                  </p>
                </div>
              </div>
            </li>
            @can('create-bidang')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Tambah Bidang</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Tambah Bidang adalah fitur untuk menambahkan data bidang.
                  </p>
                </div>
              </div>
            </li>
            @endcan
            @can('update-bidang')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Ubah Bidang</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Ubah Bidang adalah fitur yang digunakan untuk mengubah data bidang.
                  </p>
                </div>
              </div>
            </li>
            @endcan
            @can('publish-bidang')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Status Bidang</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Status Bidang adalah fitur yang digunakan untuk mengubah status bidang.
                  </p>
                </div>
              </div>
            </li>
            @endcan
          </ul>
        </div>
      </div>
    </div>
  </div>
  @endcan

  @can ('read-posisi')
  <div class="col-md-3 col-sm-3 col-xs-12 blue">
    <div class="x_panel">
      <div class="x_title">
        <h2>Posisi</h2>
        <div class="nav panel_toolbox">
          @can ('create-posisi')
          <a href="{{ route('posisi.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
          @endcan
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          <ul class="list-unstyled timeline widget">
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Posisi</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Terdapat list posisi yang sudah terdaftar.<br>
                  </p>
                </div>
              </div>
            </li>
            @can('create-posisi')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Tambah Posisi</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Tambah Posisi adalah fitur untuk menambahkan data posisi.
                  </p>
                </div>
              </div>
            </li>
            @endcan
            @can('update-posisi')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Ubah Posisi</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Ubah Posisi adalah fitur yang digunakan untuk mengubah data posisi.
                  </p>
                </div>
              </div>
            </li>
            @endcan
            @can('publish-posisi')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Status Posisi</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Status Posisi adalah fitur yang digunakan untuk mengubah status posisi.
                  </p>
                </div>
              </div>
            </li>
            @endcan
          </ul>
        </div>
      </div>
    </div>
  </div>
  @endcan

  @can ('read-plafon')
  <div class="col-md-3 col-sm-3 col-xs-12 blue">
    <div class="x_panel">
      <div class="x_title">
        <h2>Plafon</h2>
        <div class="nav panel_toolbox">
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          <ul class="list-unstyled timeline widget">
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Plafon</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Terdapat plafon yang terdiri dari Jiwa dan Kebakaran/Jiwa.<br>
                  </p>
                </div>
              </div>
            </li>
            @can('create-plafon')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Tambah Plafon</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Tambah Plafon adalah fitur untuk menambahkan data plafon yang akan digunakan dalam menambah data Akad.
                  </p>
                </div>
              </div>
            </li>
            @endcan
            @can('update-plafon')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Ubah Plafon</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Ubah Plafon adalah fitur yang digunakan untuk mengubah data plafon.
                  </p>
                </div>
              </div>
            </li>
            @endcan
            @can('create-plafon')
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Upload Plafon</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Upload Plafon adalah fitur yang digunakan untuk meng-upload plafon.<br>
                    Fitur ini digunakan hanya sekali pada saat plafon belum mempunyai data.<br>
                    Upload Plafon ini hanya untuk meng-upload skema pembiayaan yang baru, apabila ingin mengubah skema pembiayaan harap menggunakan fitur "Ubah Plafon".
                  </p>
                </div>
              </div>
            </li>
            @endcan
          </ul>
        </div>
      </div>
    </div>
  </div>
  @endcan

</div>

@can('management-user')
<div class="row">

  <div class="col-md-3 col-sm-3 col-xs-12 black">
    <div class="x_panel">
      <div class="x_title">
        <h2>Log Akses</h2>
        <div class="nav panel_toolbox">
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          <ul class="list-unstyled timeline widget">
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Log Akses</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Fitur ini berisikan aktifitas user pengguna website.<br>
                  </p>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-3 col-xs-12 black">
    <div class="x_panel">
      <div class="x_title">
        <h2>User</h2>
        <div class="nav panel_toolbox">
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          <ul class="list-unstyled timeline widget">
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">User</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Management User ini berisikan data dari pengguna website.<br>
                  </p>
                </div>
              </div>
            </li>
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Tambah User</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Tambah User, fitur ini adalah untuk menambahkan user pengguna website.<br>
                    Dapat terdiri lebih dari 1 role akses.
                  </p>
                </div>
              </div>
            </li>
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Ubah User</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Ubah User, fitur ini adalah untuk mengubah data user pengguna website.<br>
                  </p>
                </div>
              </div>
            </li>
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Status User</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Status User, fitur ini adalah untuk mengubah status user pengguna website.<br>
                  </p>
                </div>
              </div>
            </li>
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Reset Password</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Reset Password, fitur ini adalah untuk mereset password user pengguna website ke password default.<br>
                  </p>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-3 col-sm-3 col-xs-12 black">
    <div class="x_panel">
      <div class="x_title">
        <h2>Role Task</h2>
        <div class="nav panel_toolbox">
          <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="dashboard-widget-content">
          <ul class="list-unstyled timeline widget">
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Role Task</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Fitur ini adalah untuk mengatur hak akses (role task) apa saja yang boleh di akses oleh user pengguna website.<br>
                  </p>
                </div>
              </div>
            </li>
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Tambah Role</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Fitur ini adalah untuk menambah hak akses (role task).<br>
                  </p>
                </div>
              </div>
            </li>
            <li>
              <div class="block">
                <div class="block_content">
                  <h2 class="title">Ubah Role</h2>
                  <div class="byline">

                  </div>
                  <p class="excerpt">
                    Fitur ini adalah untuk mengubah hak akses (role task).<br>
                  </p>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

</div>
@endcan

@endsection
