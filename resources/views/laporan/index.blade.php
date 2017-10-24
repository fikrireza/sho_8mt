@extends('layout.master')

@section('title')
  <title>BMT Ta'Awun | Klaim</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/datepicker/datepicker3.css') }}" rel="stylesheet">
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

@if(Session::has('gagal'))
<script>
  window.setTimeout(function() {
    $(".alert-danger").fadeTo(700, 0).slideUp(700, function(){
        $(this).remove();
    });
  }, 15000);
</script>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <strong>{{ Session::get('gagal') }}</strong>
    </div>
  </div>
</div>
@endif

<div class="row">
  <div class="col-md-8 col-md-offset-2">
    <div class="x_panel">
      <div class="x_title">
        <p>Pilih Laporan</p>
      </div>
      <form action="{{ route('laporan.store') }}" method="POST" class="form-horizontal form-label-left">
      {{ csrf_field() }}
      <div class="x_content">
        @if (Auth::user()->id_bmt == null)
        <div class="item form-group {{ $errors->has('id_bmt') ? 'has-error' : ''}}">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">BMT</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="form-control select2_bmt" name="id_bmt">
              <option value=""></option>
              @foreach ($getBmt as $key)
              <option value="{{ $key->id }}" {{ old('id_bmt') == $key->id ? 'selected=""' : ''}}>{{ $key->no_induk_bmt }} | {{ $key->nama_bmt }}</option>
              @endforeach
            </select>
          </div>
        </div>
        @else
        <input type="hidden" name="id_bmt" value="{{ $getBmt }}">
        @endif
        <div class="item form-group {{ $errors->has('id_bmt') ? 'has-error' : ''}}">
          <label class="control-label col-md-3 col-sm-3 col-xs-12">Bulan</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="text" class="form-control" name="pilih_bulan" id="pilih_bulan" value="" placeholder="Klik disini" required="">
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-6 col-md-offset-3">
            <button id="send" type="submit" class="btn btn-success">Proses</button>
          </div>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('js/moment/moment.min.js') }}"></script>
<script src="{{ asset('vendors/datepicker/bootstrap-datepicker.js')}}"></script>


<script type="text/javascript">
  $('#iuran').DataTable();
  $(".select2_bmt").select2({
    placeholder: "Pilih BMT",
    allowClear: true
  });

  $('#pilih_bulan').datepicker({
    autoclose: true,
    format: 'yyyy-mm',
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    viewMode: "months",
    minViewMode: "months"
   });
</script>
@endsection
