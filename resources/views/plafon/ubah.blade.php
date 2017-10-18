@extends('layout.master')

@section('title')
  <title>BMT Taawun | Plafon</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Data Plafon</h2>
        <ul class="nav panel_toolbox">
          @if ($getPlafon[0]->jenis_plafon == 'JIWA')
            <a href="{{ route('plafon.jiwa') }}" class="btn btn-primary btn-sm">Kembali</a>
          @else
            <a href="{{ route('plafon.kebakaran') }}" class="btn btn-primary btn-sm">Kembali</a>
          @endif
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('plafon.edit') }}" method="POST" class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input name="jenis_plafon" type="hidden" value="{{ $getPlafon[0]->jenis_plafon }}">
          <div class="item form-group {{ $errors->has('jumlah_pembiayaan') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Jumlah Pembiayaan <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="jumlah_pembiayaan" class="form-control col-md-7 col-xs-12" name="jumlah_pembiayaan" placeholder="Contoh : 1000000" required="required" type="text" value="{{ old('jumlah_pembiayaan', $getPlafon[0]->jumlah_pembiayaan) }}" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
              @if($errors->has('jumlah_pembiayaan'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('jumlah_pembiayaan')}}</span></code>
              @endif
            </div>
          </div>
          @foreach ($getPlafon as $key)
          <div class="item form-group {{ $errors->has('bulan') ? 'has-error' : ''}}">
            <input type="hidden" name="cicilan[id][]" value="{{ $key->id }}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12"> <span class="required"></span></label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input id="bulan" class="form-control col-md-4 col-xs-6" name="cicilan[bulan][]" type="text" value="{{ $key->bulan }}" readonly="">
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input id="iuran" class="form-control col-md-4 col-xs-12" name="cicilan[iuran][]" placeholder="Contoh : Rupiah" type="text" value="{{ old('iuran', $key->iuran ) }}" required="" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
            </div>
          </div>
          @endforeach
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              @if ($getPlafon[0]->jenis_plafon == 'JIWA')
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
