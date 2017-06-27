@extends('layout.master')

@section('title')
  <title>BMT Taawun | Input Iuran</title>
@endsection

@section('headscript')
<link href="{{ asset('public/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
<link href="{{ asset('public/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
          <a href="{{ route('iuran.index') }}" class="btn btn-primary btn-sm">Kembali</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('iuran.store') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data" novalidate>
          {{ csrf_field() }}
          <h2>Input Iuran</h2>
          <div class="ln_solid"></div>
          <div class="item form-group {{ $errors->has('kode_iuran') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Kode Iuran <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="kode_iuran" name="kode_iuran" required="required" class="form-control col-md-7 col-xs-12" value="{{ old('kode_iuran', $kode_iuran) }}" readonly="">
              @if($errors->has('kode_iuran'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('kode_iuran')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('id_akad') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Akad <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2_akad" name="id_akad" required="" id="id_akad">
                <option value=""></option>
                @foreach($getAkad as $key)
                <option value="{{ $key->id }}" {{ old('id_akad') == $key->id ? 'selected=""' : ''}}>{{ $key->kode_akad}} | {{ $key->anggota->nama_anggota }}</option>
                @endforeach
              </select>
              @if($errors->has('id_akad'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('id_akad')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group" id="jumlah_pembiayaan">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Plafon</label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input type="text" name="jumlah_pembiayaan" class="form-control" id="jumlah_pembiayaan" value="{{ old('jumlah_pembiayaan') }}" readonly style="text-align:right;">
            </div>
          </div>
          <div class="item form-group" id="bulan">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tenor</label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input type="text" name="bulan" class="form-control" id="bulan" value="{{ old('bulan') }}" readonly>
            </div>
          </div>
          <div class="item form-group" id="jatuh_tempo">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jatuh Tempo</label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input type="text" name="jatuh_tempo" class="form-control" id="jatuh_tempo" value="{{ old('jatuh_tempo') }}" readonly>
            </div>
          </div>
          <div class="item form-group" id="iuran">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Iuran</label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input type="text" name="iuran" class="form-control" id="iuran" value="{{ old('iuran') }}" readonly style="text-align:right;">
            </div>
          </div>
          <div class="item form-group" id="jumlah_bayar">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Iuran</label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input type="text" name="jumlah_bayar" class="form-control" id="jumlah_bayar" value="{{ old('jumlah_bayar') }}" readonly style="text-align:right;">
            </div>
          </div>
          <div class="item form-group" id="sisa_iuran">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Sisa Iuran</label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input type="text" name="sisa_iuran" class="form-control" id="sisa_iuran" value="{{ old('sisa_iuran') }}" readonly style="text-align:right;">
            </div>
          </div>
          <div class="item form-group {{ $errors->has('tanggal_iuran') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Iuran <span class="required">*</span></label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input id="tanggal_iuran" name="tanggal_iuran" class="date-picker form-control" required="required" type="text" value="{{ old('tanggal_iuran') }}" readonly="">
              @if($errors->has('tanggal_iuran'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('tanggal_iuran')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('jenis_pembayaran') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Pembayaran <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control jenis_pembayaran" name="jenis_pembayaran" required="" id="jenis_pembayaran">
                <option value="">-- Pilih --</option>
                <option value="1" {{ old('jenis_pembayaran') == '1' ? 'selected=""' : '' }}>Cash</option>
                <option value="0" {{ old('jenis_pembayaran') == '0' ? 'selected=""' : '' }}>Transfer</option>
              </select>
              @if($errors->has('jenis_pembayaran'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('jenis_pembayaran')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('img_struk') ? 'has-error' : ''}}" id="img_struk">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Upload Struk <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="file" id="img_struk" name="img_struk" class="form-control col-md-7 col-xs-12" accept=".jpg,.png,.jpeg,.bmp">
              @if($errors->has('img_struk'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('img_struk')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nilai_iuran') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Jumlah Iuran <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="number" onkeypress="return isNumberKey(event)" id="nilai_iuran" name="nilai_iuran" required="required" data-validate-minmax="7,17" class="form-control col-md-7 col-xs-12" placeholder="Contoh : 12500" value="{{ old('nilai_iuran') }}">
              @if($errors->has('nilai_iuran'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nilai_iuran')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('keterangan') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Keterangan <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="keterangan" required="required" name="keterangan" class="form-control col-md-7 col-xs-12" placeholder="Contoh : Alamat">{{ old('keterangan') }}</textarea>
              @if($errors->has('keterangan'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('keterangan')}}</span></code>
              @endif
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="{{ route('anggota.index') }}" class="btn btn-primary">Cancel</a>
              <button id="send" type="submit" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection



@section('script')
<script src="{{ asset('public/vendors/validator/validator.min.js') }}"></script>
<script src="{{ asset('public/vendors/iCheck/icheck.min.js')}}"></script>
<script src="{{ asset('public/vendors/switchery/dist/switchery.min.js')}}"></script>
<script src="{{ asset('public/vendors/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('public/js/moment/moment.min.js') }}"></script>
<script src="{{ asset('public/js/datepicker/daterangepicker.js') }}"></script>

<script>
  $(".select2_akad").select2({
    placeholder: "Pilih Akad Anggota",
    allowClear: true
  });

  $(".jenis_pembayaran").select2({
    placeholder: "Pilih Jenis Pembayaran",
    allowClear: true
  });

  $('#tanggal_iuran').daterangepicker({
    singleDatePicker: true,
    calender_style: "picker_3",
    format: 'YYYY-MM-DD',
    showDropdowns: true
  });

  // initialize the validator function
  validator.message.date = 'not a real date';

  // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
  $('form')
    .on('blur', 'input[required], textarea, input.optional, select.required', validator.checkField)
    .on('change', 'select.required', validator.checkField)
    .on('keypress', 'input[required][pattern]', 'textarea', validator.keypress);

  $('.multi.required').on('keyup blur', 'input', function() {
    validator.checkField.apply($(this).siblings().last()[0]);
  });

  $('form').submit(function(e) {
    e.preventDefault();
    var submit = true;

    // evaluate the form using generic validaing
    if (!validator.checkAll($(this))) {
      submit = false;
    }

    if (submit)
      this.submit();

    return false;
  });
</script>

<script type="text/javascript">
$('#img_struk').hide();
$(document).ready(function() {
  $('select[name="id_akad"]').on('change', function() {
    var akadID = $(this).val();
    if(akadID) {
        $.ajax({
            url: '{{ url('/') }}/iuran/getAkad/'+akadID,
            type: "GET",
            dataType: "json",

            success:function(data) {
              var jumlah_pembiayaan = data.jumlah_pembiayaan;
              var jumlah_pembiayaan = parseInt(jumlah_pembiayaan).toLocaleString(
                undefined,
                {
                  minimumFractionDigits: 2
                }
              );
              var bulan = data.bulan;
              var iuran = data.iuran;
              var iuran = parseInt(iuran).toLocaleString(
                undefined,
                {
                  minimumFractionDigits: 2
                }
              )
              var jumlah_bayar = data.nilai_iuran.toLocaleString(
                undefined,
                {
                  minimumFractionDigits: 2
                }
              );
              var jatuh_tempo = data.jatuh_tempo;
              var sisa_iuran = data.jumlah_pembiayaan - data.nilai_iuran;
              var sisa_iuran = sisa_iuran.toLocaleString(
                undefined,
                {
                  minimumFractionDigits :2
                }
              );

              $('input[type="text"]#jumlah_pembiayaan').attr('value', 'Rp. '+jumlah_pembiayaan);
              $('input[type="text"]#bulan').attr('value', bulan+' Bulan');
              $('input[type="text"]#iuran').attr('value', 'Rp. '+iuran);
              $('input[type="text"]#jumlah_bayar').attr('value', 'Rp. '+jumlah_bayar);
              $('input[type="text"]#jatuh_tempo').attr('value', jatuh_tempo);
              $('input[type="text"]#sisa_iuran').attr('value', 'Rp. '+sisa_iuran);
            }
        });
    }else{
        $('input[type="text"]#id_plafon').empty();
    }
  });
});

$('select#jenis_pembayaran').on('change', function(){

  var optionSelected = $("option:selected", this);
  var valueSelected = this.value;

  if (valueSelected==1) {
    $('#img_struk').hide();
  } else if (valueSelected==0) {
    $('#img_struk').show();
  }
});

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
@endsection
