@extends('layout.master')

@section('title')
  <title>BMT Ta'Awun | Klaim</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
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
        <p>Pilih Akad</p>
      </div>
      <form action="{{ route('klaim.check') }}" method="POST" class="form-horizontal form-label-left">
      {{ csrf_field() }}
      <div class="x_content">
        <div class="item form-group {{ $errors->has('id_akad') ? 'has-error' : ''}}">
          <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_code">Akad</label>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <select class="form-control select2_akad" name="id_akad" required="">
              <option value=""></option>
              @foreach ($getAkad as $key)
              <option value="{{ $key->id }}" {{ old('id_akad') == $key->id ? 'selected=""' : ''}}>{{ $key->kode_akad }} | {{ $key->anggota->nama_anggota }}</option>
              @endforeach
            </select>
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

@if (isset($getPlafon))
  <div class="page-title">
    <div class="title_left">
      <h3>Histori Iuran<small></small></h3>
    </div>
  </div>

  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table width="100%">
            <tr>
              <td>
                <table class="table" width="30%">
                  <tr>
                    <td><b>BMT</b></td>
                    <td>{{ $getAkadnya->anggota->bmt->nama_bmt }}</td>
                  </tr>
                  <tr>
                    <td><b>Nama</b></td>
                    <td>{{ $getAkadnya->anggota->nama_anggota }}</td>
                  </tr>
                  <tr>
                    <td><b>No Akad</b></td>
                    <td>{{ $getAkadnya->kode_akad }}</td>
                  </tr>
                  <tr>
                    <td><b>Tanggal Akad</b></td>
                    <td>{{ $getAkadnya->tanggal_akad }}</td>
                  </tr>
                  <tr>
                    <td><b>Jenis Plafon</b></td>
                    <td>{{ $getPlafon->jenis_plafon == 0 ? 'Kebakaran' : 'Jiwa' }}</td>
                  </tr>
                </table>
              </td>
              <td>&nbsp;</td>
              <td>
                <table class="table" width="30%">
                  <tr>
                    <td><b>Jumlah Pembiayaan</b></td>
                    <td style="text-align:right">Rp.</td>
                    <td style="text-align:right">{{ number_format($getPlafon->jumlah_pembiayaan,'0',',','.') }}</td>
                  </tr>
                  <tr>
                    <td><b>Bulan</b></td>
                    <td style="text-align:right">{{ $getPlafon->bulan }} Bulan</td>
                    <td></td>
                  </tr>
                  <tr>
                    <td><b>Iuran/Bulan</b></td>
                    <td style="text-align:right">Rp.</td>
                    <td style="text-align:right">{{ number_format($getPlafon->iuran,'0',',','.') }}</td>
                  </tr>
                  <tr>
                    <td><b>Total Iuran</b></td>
                    <td style="text-align:right">Rp.</td>
                    <td style="text-align:right">{{ number_format($getIuran->sum('nilai_iuran'),'0',',','.') }}</td>
                  </tr>
                  @php
                    $total_iuran = $getIuran->sum('nilai_iuran');
                    $sisa_bayar = $getPlafon->jumlah_pembiayaan-$total_iuran;
                  @endphp
                  <tr>
                    <td><b>Sisa Iuran</b></td>
                    <td style="text-align:right">Rp.</td>
                    <td style="text-align:right">{{ number_format($sisa_bayar,'0',',','.')}}</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
          <hr>
          <table id="iuran" class="table table-striped table-bordered no-footer" width="100%">
            <thead>
              <tr role="row">
                <th>No</th>
                <th>Tanggal Iuran</th>
                <th>Jenis Pembayaran</th>
                <th>Nilai Iuran</th>
              </tr>
            </thead>
            <tbody>
              @php $no = 1; @endphp
              @foreach ($getIuran as $iuran)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $iuran->tanggal_iuran }}</td>
                <td>{{ $iuran->jenis_pembayaran == 1 ? 'Cash' : 'Transfer' }}</td>
                <td style="text-align:right;">Rp. {{ number_format($iuran->nilai_iuran,'0',',','.') }}</td>
              @endforeach
            </tbody>
          </table>

          @can ('create-klaim')
          <hr>
          <form action="{{ route('klaim.store') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            <input type="hidden" name="id_akad" value="{{ $getAkadnya->id }}">
            <input type="hidden" name="id_anggota" value="{{ $getAkadnya->anggota->id }}">
            <input type="hidden" name="jumlah_pembiayaan" value="{{ $getPlafon->jumlah_pembiayaan }}">
            <div class="ln_solid"></div>
            <div class="item form-group {{ $errors->has('no_permohonan') ? 'has-error' : ''}}">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">No Klaim <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="no_permohonan" required="required" name="no_permohonan" class="form-control col-md-7 col-xs-12" value="{{ old('no_permohonan') }}">
                @if($errors->has('no_permohonan'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('no_permohonan')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group {{ $errors->has('keterangan_musibah') ? 'has-error' : ''}}">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Keterangan Musibah <span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea id="keterangan_musibah" required="required" name="keterangan_musibah" class="form-control col-md-7 col-xs-12" placeholder="Contoh : Kebakaran/Jiwa">{{ old('keterangan_musibah') }}</textarea>
                @if($errors->has('keterangan_musibah'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('keterangan_musibah')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group {{ $errors->has('tanggal_musibah') ? 'has-error' : ''}}">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tanggal Musibah<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="tanggal_musibah" class="form-control col-md-7 col-xs-12" name="tanggal_musibah" required="required" type="text" value="{{ old('tanggal_musibah') }}">
                @if($errors->has('tanggal_musibah'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('tanggal_musibah')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group {{ $errors->has('sisa_bayar') ? 'has-error' : ''}}">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Sisa Bayar<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="sisa_bayar" class="form-control col-md-7 col-xs-12" name="sisa_bayar" required="required" type="text" value="{{ number_format($sisa_bayar,'0',',','.') }}" readonly="">
              </div>
            </div>
            <div class="item form-group {{ $errors->has('total_bayar') ? 'has-error' : ''}}">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Total Bayar<span class="required">*</span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="total_bayar" class="form-control col-md-7 col-xs-12" name="total_bayar" type="text" value="{{ old('total_bayar') }}" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" >
              </div>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <a href="{{ route('klaim.index') }}" class="btn btn-primary">Cancel</a>
                <button id="send" type="submit" class="btn btn-success">Submit</button>
              </div>
            </div>
          </form>
          @endcan

        </div>
      </div>
    </div>
  </div>
@endif

@endsection

@section('script')
<script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}"></script>
<script src="{{ asset('vendors/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('js/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/datepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('vendors/formatNumber.js') }}"></script>


<script type="text/javascript">
  $('#iuran').DataTable();
  $(".select2_akad").select2({
    placeholder: "Pilih Akad",
    allowClear: true
  });

  $('#tanggal_musibah').daterangepicker({
    singleDatePicker: true,
    calender_style: "picker_2",
    format: 'YYYY-MM-DD',
    showDropdowns: true
  });
</script>
@endsection
