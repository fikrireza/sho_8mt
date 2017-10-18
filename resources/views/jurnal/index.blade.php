@extends('layout.master')

@section('title')
  <title>BMT Taawun | Jurnal</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
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
    <h3>Jurnal <small></small></h3>
  </div>
</div>

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-6 col-md-offset-3">
    <div class="x_panel">
      <div class="x_title">
        <h4>Filter</h4>
      </div>
      <div class="x_content">
        <form action="{{ route('jurnal.post') }}" method="POST" class="form-horizontal form-label-left">
        {{ csrf_field() }}
        <div class="x_content">
          @if (Auth::user()->id_bmt == null)
            <div class="item form-group {{ $errors->has('id_bmt') ? 'has-error' : ''}}">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_code">BMT</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <select class="form-control select2_bmt" name="id_bmt" required="">
                  <option value=""></option>
                  @foreach ($getBmt as $key)
                    <option value="{{ $key->id }}">{{ $key->nama_bmt }} || {{ $key->no_induk_bmt }}</option>
                  @endforeach
                  <option value="ALL">SEMUA BMT</option>
                </select>
              </div>
            </div>
          @else
            <input type="hidden" name="id_bmt" value="{{ Auth::user()->id_bmt }}">
          @endif
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tahun Bulan</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input id="tanggal_jurnal" name="tanggal_jurnal" class="date-picker form-control" required="required" type="text" value="{{ old('tanggal_jurnal') }}" readonly="">
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
</div>

@if (isset($getJurnal))
<div class="row">
  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>List Jurnal Debit <small><b>{{ $bulan }}</b></small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <table id="jurnaltabel" class="table table-striped table-bordered" width="50%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Akad</th>
              <th>Iuran</th>
              <th>Tanggal</th>
              <th>Jumlah</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @php
              $total = 0;
              $no = 1;
            @endphp
            @foreach ($getJurnal as $key)
            @if ($key->jenis_jurnal == 'D')
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $key->akad->kode_akad }}</td>
              <td>{{ $key->iuran->kode_iuran }}</td>
              <td>{{ $key->tanggal_jurnal }}</td>
              <td>{{ number_format($key->jumlah,0,'.','.') }}</td>
              <td>{{ $key->keterangan_jurnal or '-'}}</td>
            </tr>
            @php
            $total += $key->jumlah;
            @endphp
            @endif
            @endforeach
            <tr>
              <td colspan="4" style="text-align:right;"><b>Total</b></td>
              <td>{{ number_format($total,0,'.','.') }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>List Jurnal Kredit <small><b>{{ $bulan }}</b></small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <table id="jurnaltabel" class="table table-striped table-bordered" width="50%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Akad</th>
              <th>Iuran</th>
              <th>Tanggal</th>
              <th>Jumlah</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @php
              $totalK = 0;
              $no = 1;
            @endphp
            @foreach ($getJurnal as $key)
            @if ($key->jenis_jurnal == 'K')
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $key->akad->kode_akad }}</td>
              <td>{{ $key->iuran->kode_iuran }}</td>
              <td>{{ $key->tanggal_jurnal }}</td>
              <td>{{ number_format($key->jumlah,0,'.','.') }}</td>
              <td>{{ $key->keterangan_jurnal or '-'}}</td>
            </tr>
            @php
            $totalK += $key->jumlah;
            @endphp
            @endif
            @endforeach
            <tr>
              <td colspan="4" style="text-align:right;"><b>Total</b></td>
              <td>{{ number_format($totalK,0,'.','.') }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endif

@endsection

@section('script')
<script src="{{ asset('vendors/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('js/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/datepicker/daterangepicker.js') }}"></script>

<script type="text/javascript">
  $(".select2_bmt").select2({
    placeholder: "Pilih BMT",
    allowClear: true
  });

  $('#tanggal_jurnal').daterangepicker({
    singleDatePicker: true,
    calender_style: "picker_2",
    format: 'YYYY-MM',
    showDropdowns: true
  });
</script>
@endsection
