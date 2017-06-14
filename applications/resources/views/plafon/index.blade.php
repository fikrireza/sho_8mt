@extends('layout.master')

@section('title')
  <title>BMT Taawun | Plafon</title>
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
    <h3>Semua Plafon<small></small></h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h4>Plafon Jiwa</h4>
        <a href="{{ route('plafon.tambah.jiwa') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        @if($getPlafonJiwa)
        <table id="tabelJiwa" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Jumlah Pembiayaan</th>
              @for ($i=3; $i <= 36; $i++)
                <th>{{ $i }} Bulan</th>
              @endfor
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getPlafonJiwaJumlah as $key)
            <tr>
              <td>{{ $no }}</td>
              <td>Rp. {{ number_format($key->jumlah_pembiayaan, 0, ',', '.') }}</td>
              @foreach ($getPlafonJiwa as $bulan)
              @if ($bulan->jumlah_pembiayaan == $key->jumlah_pembiayaan)
              <td>Rp. {{ number_format($bulan->iuran, 0, ',', '.') }}</td>
              @endif
              @endforeach
              <td><a href="" class="ubah" data-value="{{ $key->id }}" data-toggle="modal" data-target=".modal-ubah"><span class="btn btn-xs btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fa fa-pencil"></i></span></a></td>
            </tr>
            @php
              $no++;
            @endphp
            @endforeach
          </tbody>
        </table>
        @endif
      </div>
    </div>
    <div class="x_panel">
      <div class="x_title">
        <h4>Plafon Kebakaran dan Jiwa</h4>
        <a href="{{ route('plafon.tambah.kebakaran') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        @if($getPlafonKebakaran)
        <table id="tabelKebakaran" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Jumlah Pembiayaan</th>
              @for ($i=3; $i <= 36; $i++)
                <th>{{ $i }} Bulan</th>
              @endfor
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getPlafonKebakaranJumlah as $key)
            <tr>
              <td>{{ $no }}</td>
              <td>Rp. {{ number_format($key->jumlah_pembiayaan, 0, ',', '.') }}</td>
              @foreach ($getPlafonKebakaran as $bulan)
              @if ($bulan->jumlah_pembiayaan == $key->jumlah_pembiayaan)
              <td>Rp. {{ number_format($bulan->iuran, 0, ',', '.') }}</td>
              @endif
              @endforeach
              <td><a href="" class="ubah" data-value="{{ $key->id }}" data-toggle="modal" data-target=".modal-ubah"><span class="btn btn-xs btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fa fa-pencil"></i></span></a></td>
            </tr>
            @php
              $no++;
            @endphp
            @endforeach
          </tbody>
        </table>
        @endif
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
  $('#tabelKebakaran').DataTable();
  $('#tabelJiwa').DataTable();
</script>

@endsection
