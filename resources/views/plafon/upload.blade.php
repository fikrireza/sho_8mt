@extends('layout.master')

@section('title')
  <title>BMT Ta'Awun | Upload Skema Plafon</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
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
      <h3>Upload Skema Plafon<small></small></h3>
    </div>
  </div>

  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Upload</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form class="form-horizontal form-label-left" action="{{ route('plafon.download') }}" method="get">
            {{ csrf_field() }}
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <h6>Download template sebelum upload</h6>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <button id="send" type="submit" class="btn btn-primary btn-sm">Download Template</button>
              </div>
            </div>
          </form>

          <div class="ln_solid"></div>

          <form class="form-horizontal form-label-left" action="{{ route('plafon.upload') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <h6>Upload file template</h6>
              </div>
            </div>
            <div class="item form-group {{ $errors->has('file') ? 'has-error' : ''}}">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">File Upload <span class="required">*</span></label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="file" name="file" value="" accept=".xls, .xlsx">
                @if($errors->has('file'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('file')}}</span></code>
                @endif
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <button id="send" type="submit" class="btn btn-success">Upload</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('script')
<script src="{{ asset('vendors/switchery/dist/switchery.min.js')}}"></script>
<script src="{{ asset('js/moment/moment.min.js') }}"></script>
@endsection
