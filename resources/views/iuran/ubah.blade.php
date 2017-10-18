@extends('layout.master')

@section('title')
  <title>BMT Ta'Awun | Delete Iuran</title>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">

    <div class="alert alert-danger alert-dismissible fade in" role="alert">
      <strong>Hapus Record Iuran!</strong> Pastikan lagi iuran ini salah, jika telah dihapus, data didalam jurnal akan terhapus.
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Hapus Iuran</h2>
        <div class="nav panel_toolbox">
          <a href="{{ route('iuran.index') }}" class="btn btn-primary btn-sm">Kembali</a>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('iuran.delete') }}" method="POST" class="form-horizontal form-label-left">
          {{ csrf_field() }}
          <input type="hidden" name="id" value="{{ $getIuran->id }}">
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Kode Iuran</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="kode_iuran" name="kode_iuran" class="form-control col-md-7 col-xs-12" value="{{ old('kode_iuran', $getIuran->kode_iuran) }}" readonly="">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Akad</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="kode_akad" value="{{ old('kode_akad', $getIuran->akad->kode_akad) }}" class="form-control col-md-7 col-xs-12" readonly="">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Iuran</label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input type="text" name="tanggal_iuran" class="form-control" value="{{ old('tanggal_iuran', $getIuran->tanggal_iuran) }}" readonly="">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Iuran</label>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <input type="text" name="nilai_iuran" class="form-control" value="{{ old('nilai_iuran', number_format($getIuran->nilai_iuran,0,'.','.')) }}" readonly style="text-align:right;">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Pembayaran</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" name="jenis_pembayaran" value="{{ old('jenis_pembayaran', $getIuran->jenis_pembayaran)}}" class="form-control" readonly="">
            </div>
          </div>
          @if ($getIuran->img_struk != null)
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Struk</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <img src="{{ asset('documents/struk_iuran').'/'.$getIuran->img_struk }}" alt="{{ $getIuran->img_struk}}" width="30%">
            </div>
          </div>
          @endif
          <div class="item form-group {{ $errors->has('keterangan') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Keterangan</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="keterangan" required="required" name="keterangan" class="form-control col-md-7 col-xs-12" readonly="">{{ old('keterangan', $getIuran->keterangan) }}</textarea>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="{{ route('iuran.index') }}" class="btn btn-primary">Cancel</a>
              <input id="send" type="submit" class="btn buttonDisabled" value="Submit"/>
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

<script>
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
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}
</script>
@endsection
