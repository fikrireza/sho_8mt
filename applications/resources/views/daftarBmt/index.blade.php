@extends('layout.master')

@section('title')
  <title>BMT Taawun | Daftar BMT</title>
@endsection

@section('headscript')
<link href="{{ asset('public/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
<link href="{{ asset('public/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
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
          <a href="{{ route('daftar.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
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
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getBMT as $key)
            <tr>
              <td>{{ $no }}</td>
              <td>{{ $key->no_induk }}</td>
              <td>{{ $key->nama }}</td>
              <td>{{ $key->alamat }}</td>
              <td>{{ $key->mpd }}</td>
              <td>{{ $key->mpw }}</td>
              <td>{{ $key->telp }}</td>
              <td>{{ $key->nama_kontak }}</td>
              <td>{{ $key->nomor_kontak }}</td>
              <td><a href="{{ route('daftar.ubah', $key->id) }}" class="btn btn-xs btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fa fa-pencil"></i> </a></td>
            </tr>
            @php
              $no++;
            @endphp
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="{{ asset('public/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('public/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}"></script>

<script type="text/javascript">
  $('#daftartabel').DataTable();

</script>
@endsection
