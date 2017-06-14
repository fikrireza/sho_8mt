@extends('layout.master')

@section('title')
  <title>BMT Taawun | Daftar Anggota</title>
@endsection

@section('headscript')
<link href="{{ asset('public/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
<link href="{{ asset('public/vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
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
          <div class="item form-group {{ $errors->has('id_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">BMT <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2_bmt" name="id_bmt" required="">
                <option value=""></option>
                @foreach($getBmt as $key)
                <option value="{{ $key->id }}" {{ old('id_bmt') == $key->id ? 'selected=""' : ''}}>{{ $key->no_induk_bmt}} | {{ $key->nama_bmt }}</option>
                @endforeach
              </select>
              @if($errors->has('id_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('id_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('id_posisi') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Posisi/Jabatan <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2_posisi" name="id_posisi" required="">
                <option value=""></option>
                @foreach($getBidang as $bidang)
                  <optgroup label="{{ $bidang->nama_bidang }}">
                    @foreach($getPosisi as $posisi)
                      @if($posisi->id_bidang === $bidang->id)
                        <option value="{{ $posisi->id }}" {{ old('id_posisi') == $posisi->id ? 'selected=""' : ''}}>{{ $posisi->nama_posisi }}</option>
                      @endif
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
              @if($errors->has('id_posisi'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('id_posisi')}}</span></code>
              @endif
            </div>
          </div>
          @else
          <input type="hidden" name="id_bmt" value="{{ Auth::user()->id_bmt }}">
          @endif
          <div class="item form-group {{ $errors->has('kode_anggota') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Kode Anggota <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="kode_anggota" name="kode_anggota" required="required" class="form-control col-md-7 col-xs-12" value="{{ old('kode_anggota', $kode_anggota) }}" readonly="">
              @if($errors->has('kode_anggota'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('kode_anggota')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('no_ktp') ? 'has-error' : ''}}">
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
              <input id="nama_anggota" class="form-control col-md-7 col-xs-12" name="nama_anggota" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('nama_anggota') }}">
              @if($errors->has('nama_anggota'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nama_anggota')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('jenis_kelamin') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Jenis Kelamin<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              L: <input type="radio" class="flat" name="jenis_kelamin" id="jenis_kelaminL" value="L" {{ old('jenis_kelamin') == 'L' ? 'checked=""' : ''}} />
              P: <input type="radio" class="flat" name="jenis_kelamin" id="jenis_kelaminP" value="P" {{ old('jenis_kelamin') == 'P' ? 'checked=""' : ''}} />
              @if($errors->has('jenis_kelamin'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('jenis_kelamin')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('kode_pos') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Kode Pos<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="kode_pos" class="form-control col-md-7 col-xs-12" name="kode_pos" placeholder="Contoh : 12230" required="required" type="text" value="{{ old('kode_pos') }}">
              @if($errors->has('kode_pos'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('kode_pos')}}</span></code>
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
          <div class="item form-group {{ $errors->has('no_telp') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">No Telp/HP<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="no_telp" class="form-control col-md-7 col-xs-12" name="no_telp" placeholder="Contoh : 02188983982" required="required" type="text" value="{{ old('no_telp') }}">
              @if($errors->has('no_telp'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('no_telp')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('tempat_lahir') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tempat Lahir<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="tempat_lahir" class="form-control col-md-7 col-xs-12" name="tempat_lahir" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('tempat_lahir') }}">
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
          <div class="item form-group {{ $errors->has('status_pernikahan') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pernikahan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control col-md-7 col-xs-12 status_pernikahan" name="status_pernikahan" required="">
                <option value="">-- Pilih --</option>
                <option value="1" {{ old('status_pernikahan') == '1' ? 'selected=""' : '' }}>Kawin</option>
                <option value="0" {{ old('status_pernikahan') == '0' ? 'selected=""' : '' }}>Belum Kawin</option>
              </select>
              @if($errors->has('status_pernikahan'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('status_pernikahan')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('lokasi_usaha') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Lokasi Usaha<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="lokasi_usaha" class="form-control col-md-7 col-xs-12" name="lokasi_usaha" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('lokasi_usaha') }}">
              @if($errors->has('lokasi_usaha'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('lokasi_usaha')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('jenis_usaha') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Jenis Usaha<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="jenis_usaha" class="form-control col-md-7 col-xs-12" name="jenis_usaha" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('jenis_usaha') }}">
              @if($errors->has('jenis_usaha'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('jenis_usaha')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="email" class="form-control col-md-7 col-xs-12" name="email" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('email') }}">
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
<script src="{{ asset('public/vendors/iCheck/icheck.min.js')}}"></script>
<script src="{{ asset('public/vendors/switchery/dist/switchery.min.js')}}"></script>
<script src="{{ asset('public/vendors/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('public/js/moment/moment.min.js') }}"></script>
<script src="{{ asset('public/js/datepicker/daterangepicker.js') }}"></script>

<script>
  $(".select2_posisi").select2({
    placeholder: "Pilih Posisi",
    allowClear: true
  });

  $(".select2_bmt").select2({
    placeholder: "Pilih BMT",
    allowClear: true
  });

  $(".status_pernikahan").select2({
    placeholder: "Pilih Status",
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
