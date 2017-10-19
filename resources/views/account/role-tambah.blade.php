@extends('layout.master')


@section('title')
  <title>BMT Ta'Awun | Account</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">
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


<div class="page-title">
  <div class="title_left">
    <h3>Create Role Task <small></small></h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Create Access Role Task</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <form action="{{route('account.rolePost')}}" method="post" class="form-horizontal form-label-left" novalidate>
        {{ csrf_field() }}
      <div class="item form-group {{ $errors->has('name') ? 'has-error' : ''}}">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Role Name <span class="required">*</span></label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" name="name" class="form-control" value="{{ old('name') }}">
          @if($errors->has('name'))
          <code><span style="color:red; font-size:12px;">{{ $errors->first('name')}}</span></code>
          @endif
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Bidang Kerja</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-bidang]" {{ (collect(old('permissions'))->contains('read-bidang')) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-bidang]" {{ (collect(old('permissions'))->contains('create-bidang')) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[update-bidang]" {{ (collect(old('permissions'))->contains('update-bidang')) ? 'checked="checked"' : '' }} value="true" /> Update
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[publish-bidang]" {{ (collect(old('permissions'))->contains('publish-bidang')) ? 'checked="checked"' : '' }} value="true" /> Publish
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Posisi Kerja</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-posisi]" {{ (collect(old('permissions'))->contains('read-posisi')) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-posisi]" {{ (collect(old('permissions'))->contains('create-posisi')) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[update-posisi]" {{ (collect(old('permissions'))->contains('update-posisi')) ? 'checked="checked"' : '' }} value="true" /> Update
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[publish-posisi]" {{ (collect(old('permissions'))->contains('publish-posisi')) ? 'checked="checked"' : '' }} value="true" /> Publish
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Plafon Pinjaman</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-plafon]" {{ (collect(old('permissions'))->contains('read-plafon')) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-plafon]" {{ (collect(old('permissions'))->contains('create-plafon')) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[update-plafon]" {{ (collect(old('permissions'))->contains('update-plafon')) ? 'checked="checked"' : '' }} value="true" /> Update
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Daftar BMT</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-daftar]" {{ (collect(old('permissions'))->contains('read-daftar')) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-daftar]" {{ (collect(old('permissions'))->contains('create-daftar')) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[update-daftar]" {{ (collect(old('permissions'))->contains('update-daftar')) ? 'checked="checked"' : '' }} value="true" /> Update
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Anggota</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-anggota]" {{ (collect(old('permissions'))->contains('read-anggota')) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-anggota]" {{ (collect(old('permissions'))->contains('create-anggota')) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[update-anggota]" {{ (collect(old('permissions'))->contains('update-anggota')) ? 'checked="checked"' : '' }} value="true" /> Update
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[publish-anggota]" {{ (collect(old('permissions'))->contains('publish-anggota')) ? 'checked="checked"' : '' }} value="true" /> Publish
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Akad</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-akad]" {{ (collect(old('permissions'))->contains('read-akad')) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-akad]" {{ (collect(old('permissions'))->contains('create-akad')) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[approve-akad]" {{ (collect(old('permissions'))->contains('approve-akad')) ? 'checked="checked"' : '' }} value="true" /> Approve
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pembayaran/Iuran</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-pembayaran]" {{ (collect(old('permissions'))->contains('read-pembayaran')) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-pembayaran]" {{ (collect(old('permissions'))->contains('create-pembayaran')) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[delete-pembayaran]" {{ (collect(old('permissions'))->contains('delete-pembayaran')) ? 'checked="checked"' : '' }} value="true" /> Delete
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Klaim</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-klaim]" {{ (collect(old('permissions'))->contains('read-klaim')) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-klaim]" {{ (collect(old('permissions'))->contains('create-klaim')) ? 'checked="checked"' : '' }} value="true" /> Create
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jurnal</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-jurnal]" {{ (collect(old('permissions'))->contains('read-jurnal')) ? 'checked="checked"' : '' }} value="true" /> Read
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Log Akses</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-logakses]" {{ (collect(old('permissions'))->contains('read-logakses')) ? 'checked="checked"' : '' }} value="true" /> Read
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Users</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-user]" {{ (collect(old('permissions'))->contains('read-user')) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-user]" {{ (collect(old('permissions'))->contains('create-user')) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[update-user]" {{ (collect(old('permissions'))->contains('update-user')) ? 'checked="checked"' : '' }} value="true" /> Update
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[reset-user]" {{ (collect(old('permissions'))->contains('reset-user')) ? 'checked="checked"' : '' }} value="true" /> Reset
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[activate-user]" {{ (collect(old('permissions'))->contains('activate-user')) ? 'checked="checked"' : '' }} value="true" /> Status
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Roles</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-role]" {{ (collect(old('permissions'))->contains('read-role')) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-role]" {{ (collect(old('permissions'))->contains('create-role')) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[update-role]" {{ (collect(old('permissions'))->contains('update-role')) ? 'checked="checked"' : '' }} value="true" /> Update
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
          <a href="{{ route('account.roleIndex') }}" class="btn btn-primary">Cancel</a>
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
<script src="{{ asset('vendors/iCheck/icheck.min.js')}}"></script>
<script src="{{ asset('vendors/switchery/dist/switchery.min.js')}}"></script>

<script type="text/javascript">
  $("#role").select2({
    placeholder: "Choose Role",
    allowClear: true
  });
</script>
@endsection
