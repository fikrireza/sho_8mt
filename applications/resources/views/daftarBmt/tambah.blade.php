@extends('layout.master')

@section('title')
  <title>BMT Taawun | Daftar BMT</title>
@endsection

@section('headscript')
<link href="{{ asset('public/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
          <a href="{{ route('daftar.index') }}" class="btn btn-primary btn-sm">Kembali</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('daftar.store') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data" novalidate>
          {{ csrf_field() }}
          <h2>Data BMT</h2>
          <div class="ln_solid"></div>
          <div class="item form-group {{ $errors->has('no_induk') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">No. Induk <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="no_induk" class="form-control col-md-7 col-xs-12" data-validate-length-range="10" name="no_induk" placeholder="Contoh : " required="required" type="text" value="{{ old('no_induk') }}">
              @if($errors->has('no_induk'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('no_induk')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nama_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama BMT<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="nama_bmt" class="form-control col-md-7 col-xs-12" data-validate-length-range="3" name="nama_bmt" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('nama_bmt') }}">
              @if($errors->has('nama_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nama_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('alamat_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Alamat <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="alamat_bmt" required="required" name="alamat_bmt" class="form-control col-md-7 col-xs-12" placeholder="Contoh : Alamat">{{ old('alamat_bmt') }}</textarea>
              @if($errors->has('alamat_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('alamat_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('mpd') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Mpd <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="mpd" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="mpd" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('mpd') }}">
              @if($errors->has('mpd'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('mpd')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('mpw') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Mpw <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="mpw" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="mpw" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('mpw') }}">
              @if($errors->has('mpw'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('mpw')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('telp') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Telp <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="telp" name="telp" required="required" data-validate-minmax="7,15" class="form-control col-md-7 col-xs-12" placeholder="Contoh : 02177839878" value="{{ old('telp') }}">
              @if($errors->has('telp'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('telp')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nama_kontak') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama Kontak <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="nama_kontak" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="nama_kontak" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('nama_kontak') }}">
              @if($errors->has('nama_kontak'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nama_kontak')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nomor_kontak') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Nomor Kontak <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="nomor_kontak" name="nomor_kontak" required="required" data-validate-minmax="7,15" class="form-control col-md-7 col-xs-12" placeholder="Contoh : 02177839878" value="{{ old('nomor_kontak') }}">
              @if($errors->has('nomor_kontak'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nomor_kontak')}}</span></code>
              @endif
            </div>
          </div>
          <div class="ln_solid"></div>
          <h2>Data Keanggotaan</h2>
          <div class="ln_solid"></div>
          <div class="item form-group {{ $errors->has('telp') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">No Ktp <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="no_ktp" name="no_ktp" required="required" data-validate-minmax="7,17" class="form-control col-md-7 col-xs-12" placeholder="Contoh : 3175093309409009" value="{{ old('no_ktp') }}">
              @if($errors->has('no_ktp'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('no_ktp')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nama_anggota') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="nama_anggota" class="form-control col-md-7 col-xs-12" data-validate-length-range="3" name="nama_anggota" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('nama_anggota') }}">
              @if($errors->has('nama_anggota'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nama_anggota')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('alamat_anggota') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Alamat <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="alamat_anggota" required="required" name="alamat_anggota" class="form-control col-md-7 col-xs-12" placeholder="Contoh : Alamat">{{ old('alamat_anggota') }}</textarea>
              @if($errors->has('alamat_anggota'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('alamat_anggota')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('tempat_lahir') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tempat Lahir<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="tempat_lahir" class="form-control col-md-7 col-xs-12" data-validate-length-range="3" name="tempat_lahir" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('tempat_lahir') }}">
              @if($errors->has('tempat_lahir'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('tempat_lahir')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('tanggal_lahir') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Lahir <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="tanggal_lahir" name="tanggal_lahir" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" value="{{ old('tanggal_lahir') }}" readonly="">
              @if($errors->has('tanggal_lahir'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('tanggal_lahir')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('lokasi_usaha') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Lokasi Usaha<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="lokasi_usaha" class="form-control col-md-7 col-xs-12" data-validate-length-range="3" name="lokasi_usaha" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('lokasi_usaha') }}">
              @if($errors->has('lokasi_usaha'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('lokasi_usaha')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('jenis_usaha') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Jenis Usaha<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="jenis_usaha" class="form-control col-md-7 col-xs-12" data-validate-length-range="3" name="jenis_usaha" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('jenis_usaha') }}">
              @if($errors->has('jenis_usaha'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('jenis_usaha')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="email" class="form-control col-md-7 col-xs-12" data-validate-length-range="3" name="email" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('email') }}">
              @if($errors->has('email'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('email')}}</span></code>
              @endif
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="{{ route('daftar.index') }}" class="btn btn-primary">Cancel</a>
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
<script src="{{ asset('public/vendors/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('public/js/moment/moment.min.js') }}"></script>
<script src="{{ asset('public/js/datepicker/daterangepicker.js') }}"></script>

<script>
  $(".select2_single").select2({
    placeholder: "Pilih Kategori",
    allowClear: true
  });

  $('#tanggal_lahir').daterangepicker({
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
@endsection
