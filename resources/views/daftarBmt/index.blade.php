@extends('layout.master')

@section('title')
  <title>BMT Ta'Awun | Daftar BMT</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
@endsection

@section('content')
@if(Session::has('berhasil'))
<script>
  window.setTimeout(function() {
    $(".alert-success").fadeTo(700, 0).slideUp(700, function(){
        $(this).remove();
    });
  }, 5000);
</script>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="alert alert-success alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <strong>{{ Session::get('berhasil') }}</strong>
    </div>
  </div>
</div>
@endif


<div class="page-title">
  <div class="title_left">
    <h3>Semua BMT <small></small></h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Daftar BMT </h2>
        <ul class="nav panel_toolbox">
          @can('create-daftar')
          <a href="{{ route('daftar.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
          @endcan
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <table id="daftartabel" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>No. Induk</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>MPD</th>
              <th>MPW</th>
              <th>Telp</th>
              <th>Nama Kontak</th>
              <th>Nomor Kontak</th>
              <th>Email</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getBMT as $key)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $key->no_induk_bmt }}</td>
              <td>{{ $key->nama_bmt }}</td>
              <td>{{ $key->alamat_bmt }}</td>
              <td>{{ $key->mpd_bmt }}</td>
              <td>{{ $key->mpw_bmt }}</td>
              <td>{{ $key->telp_bmt }}</td>
              <td>{{ $key->nama_kontak_bmt }}</td>
              <td>{{ $key->nomor_kontak_bmt }}</td>
              <td>{{ $key->email_bmt }}</td>
              <td>
                @can('update-daftar')
                <a href="{{ route('daftar.ubah', $key->id) }}" class="btn btn-xs btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fa fa-pencil"></i></a>
                @endcan
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}"></script>

<script type="text/javascript">
  $('#daftartabel').DataTable();

</script>
@endsection
