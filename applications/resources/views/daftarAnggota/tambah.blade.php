@extends('layout.master')

@section('title')
  <title>BMT Taawun | Daftar Anggota</title>
@endsection

@section('headscript')
<link href="{{ asset('public/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
          <a href="{{ route('anggota.index') }}" class="btn btn-primary btn-sm">Kembali</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('anggota.store') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data" novalidate>
          {{ csrf_field() }}
          <h2>Data Keanggotaan</h2>
          <div class="ln_solid"></div>
          @if (session('status') === 'pbmt')
          <div class="item form-group {{ $errors->has('id_posisi') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">BMT <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2_single" name="id_posisi">
                <option value=""></option>
                @foreach ($getPosisi as $key)
                  <option value="{{ $key->id }}">{{ $key->nama_posisi}} - {{ $key->bidang->nama_bidang }}</option>
                @endforeach
              </select>
              @if($errors->has('id_posisi'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('id_posisi')}}</span></code>
              @endif
            </div>
          </div>
          @else
          <input type="hidden" name="bmt_id" value="{{ Auth::user()->bmt_id }}">
          @endif
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
              <a href="{{ route('anggota.index') }}" class="btn btn-primary">Cancel</a>
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
    placeholder: "Pilih BMT",
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
