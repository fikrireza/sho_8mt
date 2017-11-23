@extends('layout.master')

@section('title')
  <title>BMT Ta'Awun | Tambah Akun</title>
@endsection

@section('headscript')
<link href="{{ asset('/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
<link href="{{ asset('/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@if(Session::has('berhasil'))
<script>
  window.setTimeout(function() {
    $(".alert-success").fadeTo(700, 0).slideUp(700, function(){
        $(this).remove();
    });
  }, 5000);
</script>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="alert alert-success alert-dismissible fade in" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
      </button>
      <strong>{{ Session::get('berhasil') }}</strong>
    </div>
  </div>
</div>
@endif


<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tambah Akun<small></small></h2>
        <ul class="nav panel_toolbox">
          <a href="{{ route('account.userIndex') }}" class="btn btn-primary btn-sm">Kembali</a>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('account.userStore') }}" method="POST" class="form-horizontal form-label-left" novalidate enctype="multipart/form-data">
          {{ csrf_field() }}
          @if(Auth::user()->id_bmt == null)
          <div class="item form-group {{ $errors->has('jenis_akun') ? 'has-error' : ''}}" id="pilih_jenis_akun">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Jenis Akun <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="jenis_akun" name="jenis_akun" class="form-control" required="required">
                <option value="">-- Pilih --</option>
                <option value="Admin-BMT" {{ old('jenis_akun') == 'Admin-BMT' ? 'selected=""' : '' }}>Admin BMT</option>
                <option value="Administrator" {{ old('jenis_akun') == 'Administrator' ? 'selected=""' : '' }}>Administrator</option>
              </select>
              @if($errors->has('jenis_akun'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('jenis_akun')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('id_bmt') ? 'has-error' : ''}}" id="pilih_id_bmt">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">BMT<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select name="id_bmt" id="id_bmt" class="form-control" required="required">
              @foreach($getBMT as $bmt)
              <option value="{{ $bmt->id }}" {{ old('id_bmt') == $bmt->id ? 'selected=""' : '' }}>{{ $bmt->no_induk_bmt }} | {{ $bmt->nama_bmt }}</option>
              @endforeach
              </select>
              @if($errors->has('id_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('id_bmt')}}</span></code>
              @endif
            </div>
          </div>
          @else
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number"></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <code><span style="color:red; font-size:12px;">Hanya Untuk Administrator</span></code>
            </div>
          </div>
          @endif

          <div class="item form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="name" class="form-control col-md-7 col-xs-12" name="name" type="text" placeholder="E.g: John Doe" value="{{ old('name') }}">
              @if($errors->has('name'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('name')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="name" class="form-control" name="email" placeholder="E.g: john.doe@gmail.com" required="required" type="text" value="{{ old('email') }}">
              @if($errors->has('email'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('email')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('avatar') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Avatar</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="name" class="form-control" name="avatar" type="file" value="{{ old('avatar') }}" accept=".jpg,.bmp,.png">
              @if($errors->has('avatar'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('avatar')}}</span></code>
              @endif
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="item form-group {{ $errors->has('role') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Role <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="role" name="role[]" class="form-control" required="required" multiple>
                <option value="">Pilih</option>
                @foreach ($getRole as $key)
                <option value="{{ $key->id }}" {{ (collect(old('role'))->contains($key->id)) ? 'selected' : '' }}>{{ $key->name }}</option>
                @endforeach
              </select>
              @if($errors->has('role'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('role')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Active</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <label>
                <input type="checkbox" class="flat" name="active" value="1" {{ old('active') == '1' ? 'checked=""' : '' }} />
              </label>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="{{ route('account.userIndex') }}" class="btn btn-primary">Cancel</a>
              @can('create-user')
              <button id="send" type="submit" class="btn btn-success">Submit</button>
              @endcan
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
<script src="{{ asset('vendors/iCheck/icheck.min.js')}}"></script>
<script src="{{ asset('vendors/switchery/dist/switchery.min.js')}}"></script>

<script>
$('#pilih_id_bmt').hide();
  $("#role").select2({
    placeholder: "Choose Role",
    allowClear: true
  });
  $("#jenis_akun").select2({
    placeholder: "Pilih Jenis Akun",
    allowClear: true
  });

  $('select#jenis_akun').on('change', function(){

    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;

    if (valueSelected=='Admin-BMT') {
      $('#pilih_id_bmt').show();
      $("#id_bmt").select2({
          placeholder: "Pilih BMT",
          allowClear: true
        });
    } else if (valueSelected=='Administrator') {
      $('#pilih_id_bmt').hide();
    }
  });

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
  }
</script>
@endsection
