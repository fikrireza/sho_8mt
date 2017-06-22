@extends('layout.master')

@section('title')
  <title>BMT Taawun | Iuran</title>
@endsection

@section('headscript')
<link href="{{ asset('public/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
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
    <h3>Semua Iuran<small></small></h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h4>Iuran</h4>
        <a href="{{ route('iuran.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <table id="tabelIuran" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Kode Iuran</th>
              <th>Kode Akad</th>
              <th>Tanggal Iuran</th>
              <th>Jenis Pembayaran</th>
              <th>Jumlah Iuran</th>
              <th>Keterangan</th>
              {{-- <th>Aksi</th> --}}
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getIuran as $key)
            <tr>
              <td>{{ $no }}</td>
              <td>{{ $key->kode_iuran }}</td>
              <td>{{ $key->akad->kode_akad }}</td>
              <td>{{ $key->tanggal_iuran }}</td>
              <td>{{ $key->jenis_pembayaran == 1 ? 'Cash' : 'Transfer' }}</td>
              <td>Rp. {{ number_format($key->nilai_iuran, 0, ',', '.') }}</td>
              <td>{{ $key->keterangan }}</td>
              {{-- <td>Rp. {{ number_format($key->jumlah_pembiayaan, 0, ',', '.') }}</td> --}}
              {{-- <td><a href="{{ route('plafon.ubah', ['jenis_plafon' => $key->jenis_plafon, 'jumlah_pembiayaan' => $key->jumlah_pembiayaan]) }}"><span class="btn btn-xs btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fa fa-pencil"></i></span></a></td> --}}
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
<script src="{{ asset('public/vendors/select2/dist/js/select2.full.min.js')}}"></script>

<script type="text/javascript">
  $('#tabelIuran').DataTable();
</script>

@endsection
