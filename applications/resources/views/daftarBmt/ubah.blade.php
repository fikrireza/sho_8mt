@extends('layout.master')

@section('title')
  <title>BMT Taawun | Ubah Data BMT</title>
@endsection

@section('headscript')
<link href="{{ asset('public/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ubah Data BMT<small></small></h2>
        <ul class="nav panel_toolbox">
          <a href="{{ route('daftar.index') }}" class="btn btn-primary btn-sm">Kembali</a>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('daftar.edit') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data" novalidate>
          {{ csrf_field() }}
          <div class="item form-group {{ $errors->has('no_induk') ? 'has-error' : ''}}">
            <input type="hidden" name="id" value="{{ $getBMT->id }}">
            <input type="hidden" name="aktor" value="{{ Auth::user()->id }}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">No. Induk <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="no_induk" class="form-control col-md-7 col-xs-12" data-validate-length-range="10" name="no_induk" placeholder="Contoh : " required="required" type="text" value="{{ old('no_induk', $getBMT->no_induk) }}">
              @if($errors->has('no_induk'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('no_induk')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nama') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="nama" class="form-control col-md-7 col-xs-12" data-validate-length-range="3" name="nama" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('nama', $getBMT->nama) }}">
              @if($errors->has('nama'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nama')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('alamat') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Alamat <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="alamat" required="required" name="alamat" class="form-control col-md-7 col-xs-12" placeholder="Contoh : Alamat">{{ old('alamat', $getBMT->alamat) }}</textarea>
              @if($errors->has('alamat'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('alamat')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('mpd') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Mpd <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="mpd" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="mpd" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('mpd', $getBMT->mpd) }}">
              @if($errors->has('mpd'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('mpd')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('mpw') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Mpw <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="mpw" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="mpw" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('mpw', $getBMT->mpw) }}">
              @if($errors->has('mpw'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('mpw')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('telp') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Telp <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="telp" name="telp" required="required" data-validate-minmax="7,15" class="form-control col-md-7 col-xs-12" placeholder="Contoh : 02177839878" value="{{ old('telp', $getBMT->telp) }}">
              @if($errors->has('telp'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('telp')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nama_kontak') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama Kontak <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="nama_kontak" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="nama_kontak" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('nama_kontak', $getBMT->nama_kontak) }}">
              @if($errors->has('nama_kontak'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nama_kontak')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nomor_kontak') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Nomor Kontak <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="nomor_kontak" name="nomor_kontak" required="required" data-validate-minmax="7,15" class="form-control col-md-7 col-xs-12" placeholder="Contoh : 02177839878" value="{{ old('nomor_kontak', $getBMT->nomor_kontak) }}">
              @if($errors->has('nomor_kontak'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nomor_kontak')}}</span></code>
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

  $('#tanggal_post').daterangepicker({
    singleDatePicker: true,
    calender_style: "picker_3",
    format: 'YYYY-MM-DD',
    minDate: new Date(),
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
