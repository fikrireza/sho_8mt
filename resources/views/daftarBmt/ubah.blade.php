@extends('layout.master')

@section('title')
  <title>BMT Taawun | Ubah Data BMT</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
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
          <div class="item form-group {{ $errors->has('no_induk_bmt') ? 'has-error' : ''}}">
            <input type="hidden" name="id" value="{{ $getBMT->id }}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">No. Induk BMT <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="no_induk_bmt" class="form-control col-md-7 col-xs-12" data-validate-length-range="10" name="no_induk_bmt" placeholder="Contoh : " required="required" type="text" value="{{ old('no_induk_bmt', $getBMT->no_induk_bmt) }}">
              @if($errors->has('no_induk_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('no_induk_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nama_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama BMT <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="nama_bmt" class="form-control col-md-7 col-xs-12" data-validate-length-range="3" name="nama_bmt" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('nama_bmt', $getBMT->nama_bmt) }}">
              @if($errors->has('nama_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nama_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('alamat_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Alamat <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="alamat_bmt" required="required" name="alamat_bmt" class="form-control col-md-7 col-xs-12" placeholder="Contoh : Alamat">{{ old('alamat_bmt', $getBMT->alamat_bmt) }}</textarea>
              @if($errors->has('alamat_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('alamat_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('mpd_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Mpd <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="mpd_bmt" class="form-control col-md-7 col-xs-12" name="mpd_bmt" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('mpd_bmt', $getBMT->mpd_bmt) }}">
              @if($errors->has('mpd_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('mpd_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('mpw_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Mpw <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="mpw_bmt" class="form-control col-md-7 col-xs-12" name="mpw_bmt" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('mpw_bmt', $getBMT->mpw_bmt) }}">
              @if($errors->has('mpw_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('mpw_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('telp_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Telp <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="telp_bmt" name="telp_bmt" required="required" class="form-control col-md-7 col-xs-12" placeholder="Contoh : 02177839878" value="{{ old('telp_bmt', $getBMT->telp_bmt) }}">
              @if($errors->has('telp_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('telp_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nama_kontak_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama Kontak <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="nama_kontak_bmt" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="nama_kontak_bmt" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('nama_kontak_bmt', $getBMT->nama_kontak_bmt) }}">
              @if($errors->has('nama_kontak_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nama_kontak_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nomor_kontak_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Nomor Kontak <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="nomor_kontak_bmt" name="nomor_kontak_bmt" required="required" data-validate-minmax="7,15" class="form-control col-md-7 col-xs-12" placeholder="Contoh : 02177839878" value="{{ old('nomor_kontak_bmt', $getBMT->nomor_kontak_bmt) }}">
              @if($errors->has('nomor_kontak_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nomor_kontak_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('email_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email BMT<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="email_bmt" class="form-control col-md-7 col-xs-12" name="email_bmt" placeholder="Contoh : bmt@gmail.com" required="required" type="text" value="{{ old('email_bmt', $getBMT->email_bmt) }}">
              @if($errors->has('email_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('email_bmt')}}</span></code>
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
<script src="{{ asset('vendors/validator/validator.min.js') }}"></script>
<script src="{{ asset('vendors/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('js/moment/moment.min.js') }}"></script>
<script src="{{ asset('js/datepicker/daterangepicker.js') }}"></script>

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
