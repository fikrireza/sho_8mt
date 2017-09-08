@extends('layout.master')

@section('title')
  <title>BMT Taawun | Bidang</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
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


<div class="modal fade modal-ubah" id="modal-ubah" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Ubah Data Bidang</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal form-label-left" action="{{ route('bidang.edit')}}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="id" id="id_bidang" value="">
          <div class="item form-group {{ $errors->has('edit_kode_bidang') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Kode Bidang <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="edit_kode_bidang" class="form-control col-md-7 col-xs-12" name="edit_kode_bidang" required="required" type="text" value="{{ old('edit_kode_bidang') }}" readonly="">
              @if($errors->has('edit_kode_bidang'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('edit_kode_bidang')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('edit_nama_bidang') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama Bidang <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="edit_nama_bidang" class="form-control col-md-7 col-xs-12" name="edit_nama_bidang" required="required" type="text" value="{{ old('edit_nama_bidang') }}">
              @if($errors->has('edit_nama_bidang'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('edit_nama_bidang')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('edit_deskripsi') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Deskripsi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="edit_deskripsi" required="required" name="edit_deskripsi" class="form-control col-md-7 col-xs-12" placeholder="Contoh : Menangani Seluruh Pegawai">{{ old('edit_deskripsi') }}</textarea>
              @if($errors->has('edit_deskripsi'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('edit_deskripsi')}}</span></code>
              @endif
            </div>
          </div>

      </div>
      <div class="modal-footer">
        <input type="submit" value="Ubah" class="btn btn-success">
      </div>
        </form>
    </div>
  </div>
</div>

<div class="modal fade modal-unpublish" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content alert-danger">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Unpublish Bidang</h4>
      </div>
      <div class="modal-body">
        <h4>Yakin ?</h4>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="setUnpublish">Ya</a>
      </div>

    </div>
  </div>
</div>

<div class="modal fade modal-publish" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Publish Bidang</h4>
      </div>
      <div class="modal-body">
        <h4>Yakin ?</h4>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="setPublish">Ya</a>
      </div>

    </div>
  </div>
</div>


<div class="page-title">
  <div class="title_left">
    <h3>Semua Bidang<small></small></h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <a href="{{ route('bidang.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <table id="daftartabel" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Kode Bidang</th>
              <th>Nama Bidang</th>
              <th>Deskripsi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getBidang as $key)
            <tr>
              <td>{{ $no }}</td>
              <td>{{ $key->kode_bidang }}</td>
              <td>{{ $key->nama_bidang }}</td>
              <td>{{ $key->deskripsi }}</td>
              <td>@if ($key->flag_status == 1)
                <a href="" class="unpublish" data-value="{{ $key->id }}" data-toggle="modal" data-target=".modal-unpublish"><span class="btn btn-xs btn-success btn-sm"><i class="fa fa-thumbs-o-up"></i></span></a>
              @else
                <a href="" class="publish" data-value="{{ $key->id }}" data-toggle="modal" data-target=".modal-publish"><span class="btn btn-xs btn-danger btn-sm"><i class="fa fa-thumbs-o-down"></i></span></a>
              @endif
              </td>
              <td><a href="" class="ubah" data-value="{{ $key->id }}" data-toggle="modal" data-target=".modal-ubah"><span class="btn btn-xs btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fa fa-pencil"></i></span></a></td>
            </tr>
            @php
              $no++;
            @endphp
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')
<script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}"></script>

<script type="text/javascript">
  $('#daftartabel').DataTable();

  $('#daftartabel').on('click','.ubah', function(){
    var a = $(this).data('value');
    $.ajax({
      url: "{{ url('/') }}/bidang/ubah/"+a,
      dataType: 'json',
      success: function(data){
        var id_bidang = data.id;
        var kode_bidang = data.kode_bidang;
        var nama_bidang = data.nama_bidang;
        var deskripsi = data.deskripsi;

        $('#id_bidang').attr('value', id_bidang);
        $('#edit_kode_bidang').attr('value', kode_bidang);
        $('#edit_nama_bidang').attr('value', nama_bidang);
        $('#edit_deskripsi').attr('value', deskripsi);
      }
    });
  });

  $('#daftartabel').on('click','.unpublish', function(){
    var a = $(this).data('value');
    $('#setUnpublish').attr('href', "{{ url('/') }}/bidang/publish/"+a);
  });

  $(function(){
    $('a.publish').click(function(){
      var a = $(this).data('value');
      $('#setPublish').attr('href', "{{ url('/') }}/bidang/publish/"+a);
    });
  });

</script>

@if($errors->has('edit_nama_bidang') || $errors->has('edit_deskripsi') || $errors->has('edit_kode_bidang'))
<script type="text/javascript">
  $('#modal-ubah').modal('show');
</script>
@endif
@endsection
