@extends('layout.master')

@section('title')
  <title>BMT Ta'Awun | Akad</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
@endsection

@section('content')

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
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Data Akad</h2>
        <div class="nav panel_toolbox">
          <a href="{{ route('akad.index') }}" class="btn btn-primary btn-sm">Kembali</a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('akad.approveStore') }}" method="POST" class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $getAkad['id'] }}">
          <input type="hidden" name="id_anggota" value="{{ $getAkad['id_anggota'] }}">
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kode Akad</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="kode_akad" class="form-control col-md-7 col-xs-12" value="{{ $getAkad['kode_akad'] }}" readonly="">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Anggota</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="kode_anggota" class="form-control col-md-7 col-xs-12" value="{{ $getAkad->anggota->nama_anggota }}" readonly="">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Akad</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="tanggal_akad" class="form-control col-md-7 col-xs-12" type="text" value="{{ $getAkad['tanggal_akad'] }}" readonly="">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Taawun</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="jenis_plafon" class="form-control col-md-7 col-xs-12" type="text" value="{{ $getAkad->plafon->jenis_plafon }}" readonly="">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Plafon</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="plafon" class="form-control col-md-7 col-xs-12" type="text" value="Rp. {{ number_format($getAkad->plafon->jumlah_pembiayaan,0,',','.') }}" readonly="">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Iuran</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="iuran" class="form-control col-md-7 col-xs-12" type="text" value="{{ $getAkad->plafon->bulan }} Bulan | Rp. {{ number_format($getAkad->plafon->iuran,0,'.','.') }}" readonly="">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Pembayaran</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="iuran" class="form-control col-md-7 col-xs-12" type="text" value="{{ $getAkad['jenis_pembayaran'] }}" readonly="">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea required="required" name="keterangan" class="form-control col-md-7 col-xs-12" readonly>{{ $getAkad['keterangan'] }}</textarea>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Approval Akad</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              @if ($getAkad->flag_status == 'BA')
                <select class="form-control select2_jenis2" name="approval">
                  <option value="">--Pilih--</option>
                  <option value="A">Setujui</option>
                  <option value="C">Batal/Cancel</option>
                </select>
              @elseif($getAkad->flag_status == 'L')
                <input name="iuran" class="form-control col-md-7 col-xs-12" type="text" value="Lunas" readonly="">
              @else
                <input name="iuran" class="form-control col-md-7 col-xs-12" type="text" value="{{ $getAkad['flag_status'] == 'A' ? 'Sudah Disetujui' : 'Batal/Cancel' }}" readonly="">
              @endif
            </div>
          </div>
          @if ($getAkad->flag_status == 'L')
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Lunas</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input name="lunas" class="form-control col-md-7 col-xs-12" type="text" value="{{ $getAkad->tanggal_lunas }}" readonly="">
            </div>
          </div>
          @endif
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="{{ route('akad.index') }}" class="btn btn-primary">Cancel</a>
              @if ($getAkad['flag_status'] == 'BA')
                <button id="send" type="submit" class="btn btn-success">Submit</button>
              @endif
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
