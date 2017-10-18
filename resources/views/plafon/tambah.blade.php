@extends('layout.master')

@section('title')
  <title>BMT Taawun | Plafon</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')

@if(Session::has('gagal'))
<script>
  window.setTimeout(function() {
    $(".alert-danger").fadeTo(700, 0).slideUp(700, function(){
        $(this).remove();
    });
  }, 5000);
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
        <h2>Data Plafon</h2>
        <ul class="nav panel_toolbox">
          @if ($jenis_plafon == 'JIWA')
            <a href="{{ route('plafon.jiwa') }}" class="btn btn-primary btn-sm">Kembali</a>
          @else
            <a href="{{ route('plafon.kebakaran') }}" class="btn btn-primary btn-sm">Kembali</a>
          @endif
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('plafon.store') }}" method="POST" class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input name="jenis_plafon" type="hidden" value="{{ $jenis_plafon }}">
          <div class="item form-group {{ $errors->has('jumlah_pembiayaan') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Jumlah Pembiayaan <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="jumlah_pembiayaan" class="form-control col-md-7 col-xs-12" name="jumlah_pembiayaan" placeholder="Contoh : 1000000" required="required" type="text" value="{{ old('jumlah_pembiayaan') }}" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
              @if($errors->has('jumlah_pembiayaan'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('jumlah_pembiayaan')}}</span></code>
              @endif
            </div>
          </div>
          @php
          $callBack = 0;
          @endphp
          @for ($i=3; $i <=36; $i++)
          <div class="item form-group {{ $errors->has('bulan') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"></label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input id="bulan" length="2" class="form-control col-md-2 col-xs-4" name="bulan[]" type="text" value="{{ $i }}" readonly="">
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input id="iuran" class="form-control col-md-4 col-xs-12" name="iuran[]" placeholder="Contoh : Rupiah" type="text" value="{{ old('iuran.'.$callBack) }}" required="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
            </div>
          </div>
          @php
            $callBack++;
          @endphp
          @endfor
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              @if ($jenis_plafon == 'JIWA')
                <a href="{{ route('plafon.jiwa') }}" class="btn btn-primary">Cancel</a>
              @else
                <a href="{{ route('plafon.kebakaran') }}" class="btn btn-primary">Cancel</a>
              @endif
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
<script src="{{ asset('vendors/formatNumber.js') }}"></script>

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
