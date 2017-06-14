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
          <a href="{{ route('plafon.index') }}" class="btn btn-primary btn-sm">Kembali</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <h2>Data Plafon</h2>
        <form action="{{ route('plafon.store') }}" method="POST" class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input name="jenis_plafon" type="hidden" value="{{ $jenis_plafon }}">
          <div class="ln_solid"></div>
          <div class="item form-group {{ $errors->has('jumlah_pembiayaan') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Jumlah Pembiayaan <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="jumlah_pembiayaan" class="form-control col-md-7 col-xs-12" name="jumlah_pembiayaan" placeholder="Contoh : 1000000" required="required" type="text" value="{{ old('jumlah_pembiayaan') }}">
              @if($errors->has('jumlah_pembiayaan'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('jumlah_pembiayaan')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('bulan') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bulan <span class="required">*</span></label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              @for ($i=3; $i <=36; $i++)
              <input id="bulan" class="form-control col-md-4 col-xs-6" name="bulan[]" type="text" value="{{ $i }}" readonly="">
              @endfor
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
              @for ($i=3; $i <= 36; $i++)
              <input id="iuran" class="form-control col-md-4 col-xs-12" name="iuran[]" placeholder="Contoh : Rupiah" type="text" value="{{ old('iuran') }}" required="">
              @endfor
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="{{ route('plafon.index') }}" class="btn btn-primary">Cancel</a>
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
    placeholder: "Pilih Bulan",
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
