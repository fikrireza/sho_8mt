@extends('layout.master')

@section('title')
  <title>BMT Taawun | Daftar Akad</title>
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
    <h3>Semua Akad<small></small></h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <a href="{{ route('akad.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <table id="daftartabel" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Kode Akad</th>
              <th>Kode Anggota</th>
              <th>Plafon</th>
              <th>Tanggal Akad</th>
              <th>Jenis Pembayaran</th>
              <th>Keterangan</th>
              <th>Status Akad</th>
              <th>Disetujui Oleh</th>
              <th>Tanggal Disetujui</th>
              {{-- <th>Aksi</th> --}}
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getAkad as $key)
            <tr>
              <td>{{ $no }}</td>
              <td>{{ $key->kode_akad }}</td>
              <td>{{ $key->anggota->kode_anggota }} <br /> {{ $key->anggota->nama_anggota }}</td>
              <td>Rp. {{ number_format($key->plafon->jumlah_pembiayaan, 0, ',', '.') }} <br> Bln {{ $key->plafon->bulan }} <br> Iuran Rp.{{ number_format($key->plafon->iuran, 0, ',', '.') }}</td>
              <td>{{ $key->tanggal_akad }}</td>
              <td>{{ ($key->jenis_pembayaran == 1) ? 'Cash' : 'Transfer' }}</td>
              <td>{{ $key->keterangan }}</td>
              <td>{!! ($key->flag_status == 1) ? '<span class="label label-primary">Aktif</span>' : '<span class="label label-danger">Hangus</span>' !!}</td>
              <td>{!! ($key->approved_by != null) ? '<span class="label label-primary">'.$key->approveBy->nama_anggota.'</span>' : '<span class="label label-warning">Belum Disetujui</span>' !!}</td>
              <td>{!! ($key->approved_date != null) ? '<span class="label label-primary">'.$key->approved_date.'</span>' : '<span class="label label-warning">Belum Disetujui</span>' !!}</td>
              {{-- <td><a href="" class="btn btn-xs btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fa fa-pencil"></i> </a></td> --}}
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