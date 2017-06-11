@extends('layout.master')

@section('title')
  <title>BMT Taawun | Daftar BMT</title>
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
          <a href="{{ route('daftar.index') }}" class="btn btn-primary btn-sm">Kembali</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('daftar.store') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data" novalidate>
          {{ csrf_field() }}
          <h2>Data BMT</h2>
          <div class="ln_solid"></div>
          <div class="item form-group {{ $errors->has('no_induk_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">No. Induk <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="no_induk_bmt" class="form-control col-md-7 col-xs-12" name="no_induk_bmt" required="required" type="text" value="{{ $kode_bmt }}" readonly="">
              @if($errors->has('no_induk_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('no_induk_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nama_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama BMT<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="nama_bmt" class="form-control col-md-7 col-xs-12" data-validate-length-range="3" name="nama_bmt" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('nama_bmt') }}">
              @if($errors->has('nama_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nama_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('alamat_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Alamat <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="alamat_bmt" required="required" name="alamat_bmt" class="form-control col-md-7 col-xs-12" placeholder="Contoh : Alamat">{{ old('alamat_bmt') }}</textarea>
              @if($errors->has('alamat_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('alamat_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('mpd_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Mpd <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="mpd_bmt" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="mpd_bmt" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('mpd_bmt') }}">
              @if($errors->has('mpd_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('mpd_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('mpw_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Mpw <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="mpw_bmt" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="mpw_bmt" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('mpw_bmt') }}">
              @if($errors->has('mpw_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('mpw_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('telp_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Telepon BMT <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="telp_bmt" name="telp_bmt" required="required" data-validate-minmax="7,15" class="form-control col-md-7 col-xs-12" placeholder="Contoh : 02177839878" value="{{ old('telp_bmt') }}">
              @if($errors->has('telp_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('telp_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nama_kontak_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama Kontak <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="nama_kontak_bmt" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="nama_kontak_bmt" placeholder="Contoh : e.g John Doe" required="required" type="text" value="{{ old('nama_kontak_bmt') }}">
              @if($errors->has('nama_kontak_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nama_kontak_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('nomor_kontak_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Nomor Kontak <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" id="nomor_kontak_bmt" name="nomor_kontak_bmt" required="required" data-validate-minmax="7,15" class="form-control col-md-7 col-xs-12" placeholder="Contoh : 02177839878" value="{{ old('nomor_kontak_bmt') }}">
              @if($errors->has('nomor_kontak_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('nomor_kontak_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group {{ $errors->has('email_bmt') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Email BMT<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="email_bmt" class="form-control col-md-7 col-xs-12" name="email_bmt" placeholder="Contoh : bmt@gmail.com" required="required" type="text" value="{{ old('email_bmt') }}">
              @if($errors->has('email_bmt'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('email_bmt')}}</span></code>
              @endif
            </div>
          </div>
          <div class="ln_solid"></div>
          <h2>Data Keanggotaan</h2>
          <div class="ln_solid"></div>
          <div class="item form-group {{ $errors->has('kode_anggota') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Kode Anggota <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="kode_anggota" class="form-control col-md-7 col-xs-12" name="kode_anggota" required="required" type="text" value="{{ $kode_anggota }}" readonly="">
              @if($errors->has('kode_anggota'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('kode_anggota')}}</span></code>
              @endif
            </div>
          </div>
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
          <div class="item form-group {{ $errors->has('id_posisi') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Posisi BMT <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control col-md-7 col-xs-12 select2_single" name="id_posisi" id="id_posisi">
                <option value="">--Pilih--</option>
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
          <div class="item form-group {{ $errors->has('alamat') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Alamat <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="alamat" required="required" name="alamat" class="form-control col-md-7 col-xs-12" placeholder="Contoh : Alamat">{{ old('alamat') }}</textarea>
              @if($errors->has('alamat'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('alamat')}}</span></code>
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
          <div class="item form-group {{ $errors->has('status_pernikahan') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status Pernikahan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control col-md-7 col-xs-12 status_pernikahan" name="status_pernikahan">
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
<script src="{{ asset('public/vendors/validator/validator.min.js') }}"></script>
<script src="{{ asset('public/vendors/iCheck/icheck.min.js')}}"></script>
<script src="{{ asset('public/vendors/switchery/dist/switchery.min.js')}}"></script>
<script src="{{ asset('public/vendors/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('public/js/moment/moment.min.js') }}"></script>
<script src="{{ asset('public/js/datepicker/daterangepicker.js') }}"></script>

<script>
  $(".select2_single").select2({
    placeholder: "Pilih Posisi",
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
