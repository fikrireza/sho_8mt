@extends('layout.master')

@section('title')
  <title>BMT Ta'Awun | Daftar Akad</title>
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

@can('approve-akad')
<div class="modal fade modal-approve" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Setujui Akad</h4>
      </div>
      <div class="modal-body">
        <h4>Yakin ?</h4>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="setApproved">Ya</a>
      </div>
    </div>
  </div>
</div>
@endcan


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
        <h2>List Akad</h2>
        <div class="nav panel_toolbox">
          @can ('create-akad')
          <a href="{{ route('akad.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
          @endcan
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <table id="daftartabel" class="table table-striped table-bordered nowrap" width="100%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Kode Akad</th>
              <th>Kode Anggota</th>
              <th>Plafon</th>
              <th>Tanggal Akad</th>
              <th>Jatuh Tempo</th>
              <th>Jenis Pembayaran</th>
              <th>Keterangan</th>
              <th>Status Akad</th>
              <th>Disetujui Oleh</th>
              <th>Tanggal Disetujui</th>
              @can('approve-akad')
              <th>Aksi</th>
              @endcan
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getAkad as $key)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $key->kode_akad }}</td>
              <td>{{ $key->anggota->kode_anggota }} <br /> {{ $key->anggota->nama_anggota }}</td>
              <td>Rp. {{ number_format($key->plafon->jumlah_pembiayaan, 2, ',', '.') }} <br> {{ $key->plafon->bulan }} Bulan <br> Iuran Rp.{{ number_format($key->plafon->iuran, 2, ',', '.') }} <br> {{ $key->plafon->jenis_plafon }}</td>
              <td>{{ $key->tanggal_akad }}</td>
              @php
                $tanggal_akad = $key->tanggal_akad;
                $jumlah_bulan = "+".$key->plafon->bulan." months";
                $due_date = strtotime($jumlah_bulan, strtotime($tanggal_akad));
              @endphp
              <td>{{ date('Y-m-d',$due_date) }}</td>
              <td>{{ $key->jenis_pembayaran }}</td>
              <td>{{ $key->keterangan }}</td>
              <td>@if ($key->flag_status == 'BA')
                    <span class="label label-warning">Belum Disetujui</span>
                  @elseif($key->flag_status == 'A')
                    <span class="label label-success">Disetujui</span>
                  @elseif($key->flag_status == 'C')
                    <span class="label label-danger">Batal</span>
                  @elseif($key->flag_status == 'L')
                    <span class="label label-primary">Lunas</span>
                  @else
                    <span class="label label-info">Klaim</span>
                  @endif
              </td>
              <td>
                {!! ($key->approved_by != null) ? '<span class="label label-primary">'.$key->approveBy->name.'</span>' : '<span class="label label-warning">Belum Disetujui</span>' !!}
              </td>
              <td>
                {!! ($key->approved_date != null) ? '<span class="label label-primary">'.$key->approved_date.'</span>' : '<span class="label label-warning">Belum Disetujui</span>' !!}
              </td>
              @can('approve-akad')
              <td>
                <a href="{{ route('akad.approve', $key->id) }}" class="btn btn-sm btn-warning"> Lihat</span></a>
              </td>
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

<script type="text/javascript">
  $('#daftartabel').DataTable();
</script>
@endsection
