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


<div class="page-title">
  <div class="title_left">
    <h3>Edit Role Task <small></small></h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
  <div class="x_panel">
    <div class="x_title">
      <h2>Edit Access Role Task</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <form action="{{route('account.roleEdit')}}" method="post" class="form-horizontal form-label-left" novalidate>
        {{ csrf_field() }}
      <div class="item form-group {{ $errors->has('name') ? 'has-error' : ''}}">
        <input type="hidden" name="slug" value="{{ $getRole->slug }}">
        <input type="hidden" name="id" value="{{ $getRole->id }}">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Role Name <span class="required">*</span></label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" name="name" class="form-control" value="{{ $getRole->name }}" readonly>
          @if($errors->has('name'))
          <code><span style="color:red; font-size:12px;">{{ $errors->first('name')}}</span></code>
          @endif
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Plafon Pinjaman</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-plafon]" {{ in_array('read-plafon',$can) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-plafon]" {{ in_array('create-plafon',$can) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[update-plafon]" {{ in_array('update-plafon',$can) ? 'checked="checked"' : '' }} value="true" /> Update
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Daftar BMT</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-daftar]" {{ in_array('read-daftar',$can) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-daftar]" {{ in_array('create-daftar',$can) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[update-daftar]" {{ in_array('update-daftar',$can) ? 'checked="checked"' : '' }} value="true" /> Update
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Anggota</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-anggota]" {{ in_array('read-anggota',$can) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-anggota]" {{ in_array('create-anggota',$can) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[update-anggota]" {{ in_array('update-anggota',$can) ? 'checked="checked"' : '' }} value="true" /> Update
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[publish-anggota]" {{ in_array('publish-anggota',$can) ? 'checked="checked"' : '' }} value="true" /> Publish
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Akad</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-akad]" {{ in_array('read-akad',$can) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-akad]" {{ in_array('create-akad',$can) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[approve-akad]" {{ in_array('approve-akad',$can) ? 'checked="checked"' : '' }} value="true" /> Approve
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Pembayaran/Iuran</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-pembayaran]" {{ in_array('read-pembayaran',$can) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-pembayaran]" {{ in_array('create-pembayaran',$can) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[delete-pembayaran]" {{ in_array('delete-pembayaran',$can) ? 'checked="checked"' : '' }} value="true" /> Delete
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Klaim</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-klaim]" {{ in_array('read-klaim',$can) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-klaim]" {{ in_array('create-klaim',$can) ? 'checked="checked"' : '' }} value="true" /> Create
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Jurnal</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-jurnal]" {{ in_array('read-jurnal',$can) ? 'checked="checked"' : '' }} value="true" /> Read
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Laporan</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-laporan]" {{ in_array('read-laporan',$can) ? 'checked="checked"' : '' }} value="true" /> Read
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Log Akses</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-logakses]" {{ in_array('read-logakses',$can) ? 'checked="checked"' : '' }} value="true" /> Read
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Users</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-user]" {{ in_array('read-user',$can) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-user]" {{ in_array('create-user',$can) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[update-user]" {{ in_array('update-user',$can) ? 'checked="checked"' : '' }} value="true" /> Update
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[reset-user]" {{ in_array('reset-user',$can) ? 'checked="checked"' : '' }} value="true" /> Reset
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[activate-user]" {{ in_array('activate-user',$can) ? 'checked="checked"' : '' }} value="true" /> Status
          </label>
        </div>
      </div>
      <div class="ln_solid"></div>
      <div class="item form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Roles</label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <label>
            <input type="checkbox" class="flat" name="permissions[read-role]" {{ in_array('read-role',$can) ? 'checked="checked"' : '' }} value="true" /> Read
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[create-role]" {{ in_array('create-role',$can) ? 'checked="checked"' : '' }} value="true" /> Create
          </label><br>
          <label>
            <input type="checkbox" class="flat" name="permissions[update-role]" {{ in_array('update-role',$can) ? 'checked="checked"' : '' }} value="true" /> Update
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
