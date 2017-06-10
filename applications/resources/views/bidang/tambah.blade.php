@extends('layout.master')

@section('title')
  <title>BMT Taawun | Bidang</title>
@endsection

@section('headscript')
<link href="{{ asset('public/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
          <a href="{{ route('bidang.index') }}" class="btn btn-primary btn-sm">Kembali</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('bidang.store') }}" method="POST" class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <h2>Data Bidang</h2>
          <div class="ln_solid"></div>
          <div class="item form-group {{ $errors->has('kode_bidang') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Kode Bidang <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="kode_bidang" class="form-control col-md-7 col-xs-12" name="kode_bidang" required="required" type="text" value="{{ $kode_bidang }}" readonly="">
              @if($errors->has('kode_bidang'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('kode_bidang')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nama_bidang') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama Bidang<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="nama_bidang" class="form-control col-md-7 col-xs-12" name="nama_bidang" placeholder="Contoh : e.g Kepegawaian" required="required" type="text" value="{{ old('nama_bidang') }}">
              @if($errors->has('nama_bidang'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nama_bidang')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('deskripsi') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Deskripsi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="deskripsi" required="required" name="deskripsi" class="form-control col-md-7 col-xs-12" placeholder="Contoh : Menangani Seluruh Pegawai">{{ old('deskripsi') }}</textarea>
              @if($errors->has('deskripsi'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('deskripsi')}}</span></code>
              @endif
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="{{ route('bidang.index') }}" class="btn btn-primary">Cancel</a>
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

<script>
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
