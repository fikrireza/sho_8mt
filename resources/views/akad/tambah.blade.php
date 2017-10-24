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
        <a href="{{ route('akad.index') }}" class="btn btn-primary btn-sm">Kembali</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('akad.store') }}" method="POST" class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <h2>Data Akad</h2>
          <div class="ln_solid"></div>
          <div class="item form-group {{ $errors->has('kode_akad') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Kode Akad <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="kode_anggota" name="kode_akad" required="required" class="form-control col-md-7 col-xs-12" value="{{ old('kode_akad') }}" placeholder="Contoh : Kode Akad">
              @if($errors->has('kode_akad'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('kode_akad')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('id_anggota') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Anggota <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2_anggota" name="id_anggota" required="">
                <option value=""></option>
                @foreach($getAnggota as $key)
                <option value="{{ $key->id }}" {{ old('id_anggota') == $key->id ? 'selected=""' : ''}}>{{ $key->kode_anggota}} | {{ $key->nama_anggota }}</option>
                @endforeach
              </select>
              @if($errors->has('id_anggota'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('id_anggota')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('tanggal_akad') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Akad <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="tanggal_akad" name="tanggal_akad" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" value="{{ old('tanggal_akad', date('Y-m-d')) }}" readonly="">
              @if($errors->has('tanggal_akad'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('tanggal_akad')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('jenis_plafon') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Jenis Taawun <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2_jenis2" name="jenis_plafon" id="jenis_plafon">
                <option value="">--Pilih--</option>
                <option value="JIWA">Jiwa</option>
                <option value="KEBAKARAN">Kebakaran & Jiwa</option>
              </select>
              @if($errors->has('jenis_plafon'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('jenis_plafon')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('jumlah_pembiayaan') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Plafon <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="jumlah_pembiayaan" class="form-control select2_plafon" style="width:350px" id="jumlah_pembiayaan">
                <option value="">-- Pilih Plafon --</option>
              </select>
              @if($errors->has('jumlah_pembiayaan'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('jumlah_pembiayaan')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('bulan') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Iuran <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="bulan" class="form-control select2_plafon_bulan" style="width:350px">
                <option value="">-- Pilih Iuran --</option>
              </select>
              @if($errors->has('bulan'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('bulan')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('jenis_pembayaran') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Pembayaran <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control col-md-7 col-xs-12 select2_jenis" name="jenis_pembayaran" required="">
                <option value="">-- Pilih --</option>
                <option value="CASH" {{ old('jenis_pembayaran') == 'CASH' ? 'selected=""' : '' }}>Cash</option>
                <option value="TRANSFER" {{ old('jenis_pembayaran') == 'TRANSFER' ? 'selected=""' : '' }}>Transfer</option>
              </select>
              @if($errors->has('jenis_pembayaran'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('jenis_pembayaran')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('keterangan') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Keterangan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="keterangan" required="required" name="keterangan" class="form-control col-md-7 col-xs-12" placeholder="Contoh : ">{{ old('keterangan') }}</textarea>
              @if($errors->has('keterangan'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('keterangan')}}</span></code>
              @endif
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="{{ route('akad.index') }}" class="btn btn-primary">Cancel</a>
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
<script src="{{ asset('vendors/validator/validator.min.js') }}"></script>
<script src="{{ asset('vendors/iCheck/icheck.min.js')}}"></script>
<script src="{{ asset('vendors/switchery/dist/switchery.min.js')}}"></script>
<script src="{{ asset('vendors/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('js/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/datepicker/daterangepicker.js') }}"></script>

<script>
  $(".select2_anggota").select2({
    placeholder: "Pilih Anggota",
    allowClear: true
  });

  $(".select2_plafon").select2({
    placeholder: "Pilih Plafon",
    allowClear: true
  });

  $(".select2_plafon_bulan").select2({
    placeholder: "Pilih Iuran",
    allowClear: true
  });

  $(".select2_jenis2").select2({
    placeholder: "Pilih Jenis Plafon",
    allowClear: true
  });

  $(".select2_jenis").select2({
    placeholder: "Pilih Jenis Pembayaran",
    allowClear: true
  });

  $('#tanggal_akad').daterangepicker({
    singleDatePicker: true,
    calender_style: "picker_2",
    format: 'YYYY-MM-DD',
    showDropdowns: true
  });

  $(document).ready(function() {
    $('select[name="jenis_plafon"]').on('change', function() {
      var plafonID = $(this).val();
      if(plafonID) {
          $.ajax({
              url: '{{ url('/') }}/plafon/getPlafonList/'+plafonID,
              type: "GET",
              dataType: "json",

              success:function(data) {
                $.each(data, function(key, value) {
                  var nilai = parseInt(value).toLocaleString(
                    undefined,
                    {
                      minimumFractionDigits: 2
                    }
                  );
                    $('select[name="jumlah_pembiayaan"]').append('<option value="'+ value +'">'+ nilai +'</option>');
                });
              }
          });
      }else{
          $('select[name="jumlah_pembiayaan"]').empty();
      }
    });
  });

  $(document).ready(function(){
    $('select[name="jumlah_pembiayaan"]').on('change', function(){
      var jumlah_pembiayaan = $(this).val();
      var jenis_plafon = document.getElementById("jenis_plafon").value;

      if(jumlah_pembiayaan){
        $.ajax({
            url: '{{ url('/')}}/plafon/getPlafonList/'+jenis_plafon+'/'+jumlah_pembiayaan,
            type: 'GET',
            dataType: 'json',

            success:function(data){
              $.each(data, function(key, value){
                var nilai = parseInt(key).toLocaleString(
                  undefined,
                  {
                    minimumFractionDigits: 2
                  }
                );
                $('select[name="bulan"]').append('<option value="'+ value +'">'+ value +' Bln, Rp. '+ nilai +'</option>')
              });
            }
        });
      }else{
        $('select[name="bulan"]').empty();
      }
    });
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
@endsection
