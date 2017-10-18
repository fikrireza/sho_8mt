@extends('layout.master')

@section('title')
  <title>BMT Ta'Awun | Iuran</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
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
    <h3>Semua Iuran<small></small></h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Iuran</h2>
        @can('create-pembayaran')
        <div class="nav panel_toolbox">
          <a href="{{ route('iuran.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
        </div>
        @endcan
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <form class="form-inline text-center">
          <select name="tahun" class="form-control select_tahun" onchange="this.form.submit()">
            <option value="">Pilih Tahun</option>
            <option value="2016" {{ $request == '2016' ? 'selected=""' : ''}}>2016</option>
            <option value="2017" {{ $request == '2017' ? 'selected=""' : ''}}>2017</option>
            <option value="2018" {{ $request == '2018' ? 'selected=""' : ''}}>2018</option>
            <option value="2019" {{ $request == '2019' ? 'selected=""' : ''}}>2019</option>
          </select>
        </form>
        <div class="ln_solid"></div>
        <table id="tabelIuran" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Kode Iuran</th>
              <th>Kode Akad</th>
              <th>Peserta</th>
              <th>Tanggal Iuran</th>
              <th>Jenis Pembayaran</th>
              <th>Bukti Transfer</th>
              <th>Jumlah Iuran</th>
              <th>Keterangan</th>
              @can('delete-pembayaran')
              <th>Aksi</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getIuran as $key)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $key->kode_iuran }}</td>
              <td>{{ $key->akad->kode_akad }}</td>
              <td>{{ $key->akad->anggota->nama_anggota }}</td>
              <td>{{ $key->tanggal_iuran }}</td>
              <td>{{ $key->jenis_pembayaran }}</td>
              <td><a href="{{ asset('documents/struk_iuran/').'/'.$key->img_struk}}" download>{{ $key->img_struk ? 'Download' : '-'}}</a></td>
              <td>Rp. {{ number_format($key->nilai_iuran, 0, ',', '.') }}</td>
              <td>{{ $key->keterangan }}</td>
              @can('delete-pembayaran')
              <td><a href="{{ route('iuran.hapus', ['kode_iuran' => $key->kode_iuran]) }}"><span class="btn btn-xs btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></span></a></td>
              @endcan
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
<script src="{{ asset('vendors/select2/dist/js/select2.full.min.js')}}"></script>

<script type="text/javascript">
  $(".select_tahun").select2({
    placeholder: "Pilih Tahun",
    allowClear: true
  });

  $('#tabelIuran').DataTable();
</script>

@endsection
