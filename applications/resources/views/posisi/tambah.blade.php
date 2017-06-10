@extends('layout.master')

@section('title')
  <title>BMT Taawun | Posisi</title>
@endsection

@section('headscript')
<link href="{{ asset('public/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
          <a href="{{ route('posisi.index') }}" class="btn btn-primary btn-sm">Kembali</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <h2>Data Posisi</h2>
        <form action="{{ route('posisi.store') }}" method="POST" class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <div class="ln_solid"></div>
          <div class="item form-group {{ $errors->has('kode_posisi') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Kode Posisi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="kode_posisi" class="form-control col-md-7 col-xs-12" name="kode_posisi" required="required" type="text" value="{{ $kode_posisi }}" readonly="">
              @if($errors->has('kode_posisi'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('kode_posisi')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('id_bidang') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bidang <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2" name="id_bidang" required="">
                <option value="">--Pilih--</option>
                @foreach ($getBidang as $key)
                <option value="{{ $key->id }}">{{ $key->nama_bidang}}</option>
                @endforeach
              </select>
              @if($errors->has('id_bidang'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('id_bidang')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nama_posisi') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama Posisi<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="nama_posisi" class="form-control col-md-7 col-xs-12" name="nama_posisi" placeholder="Contoh : e.g Kepegawaian" required="required" type="text" value="{{ old('nama_posisi') }}">
              @if($errors->has('nama_posisi'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nama_posisi')}}</span></code>
              @endif
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="{{ route('posisi.index') }}" class="btn btn-primary">Cancel</a>
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

<script>
  $(".select2").select2({
    placeholder: "Pilih Kategori",
    allowClear: true
  });

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
