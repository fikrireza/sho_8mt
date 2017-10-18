@extends('layout.master')

@section('title')
  <title>BMT Taawun | Posisi</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
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

@can('update-posisi')
<div class="modal fade modal-ubah" id="modal-ubah" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Ubah Data Posisi</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal form-label-left" action="{{ route('posisi.edit')}}" method="post">
          {{ csrf_field() }}
          <input type="hidden" name="id" id="id_posisi" value="">
          <div class="item form-group {{ $errors->has('id_bidang') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Bidang <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control col-md-7 col-xs-12 select2" name="id_bidang" required="">
                <option value="">--Pilih--</option>
                @foreach ($getBidang as $key)
                <option value="{{ $key->id }}" id="edit_id_bidang">{{ $key->nama_bidang}}</option>
                @endforeach
              </select>
              @if($errors->has('id_bidang'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('id_bidang')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('edit_kode_posisi') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Kode posisi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="edit_kode_posisi" class="form-control col-md-7 col-xs-12" name="edit_kode_posisi" required="required" type="text" value="{{ old('edit_kode_posisi') }}" readonly="">
              @if($errors->has('edit_kode_posisi'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('edit_kode_posisi')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('edit_nama_posisi') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nama posisi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="edit_nama_posisi" class="form-control col-md-7 col-xs-12" name="edit_nama_posisi" required="required" type="text" value="{{ old('edit_nama_posisi') }}">
              @if($errors->has('edit_nama_posisi'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('edit_nama_posisi')}}</span></code>
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
@endcan

@can('publish-posisi')
<div class="modal fade modal-unpublish" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content alert-danger">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Unpublish posisi</h4>
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
        <h4 class="modal-title" id="myModalLabel2">Publish posisi</h4>
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
@endcan

<div class="page-title">
  <div class="title_left">
    <h3>Semua posisi<small></small></h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Posisi Kerja</h2>
        <ul class="nav panel_toolbox">
          @can('create-posisi')
          <a href="{{ route('posisi.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Tambah</a>
          @endcan
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <table id="daftartabel" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Bidang</th>
              <th>Kode Posisi</th>
              <th>Nama Posisi</th>
              @can('publish-posisi')
              <th>Status</th>
              @endcan
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getPosisi as $key)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $key->bidang->nama_bidang }}</td>
              <td>{{ $key->kode_posisi }}</td>
              <td>{{ $key->nama_posisi }}</td>
              @can('publish-posisi')
              <td>@if ($key->flag_aktif == "Y")
                    <a href="" class="unpublish" data-value="{{ $key->id }}" data-toggle="modal" data-target=".modal-unpublish" title="Aktif"><span class="btn btn-xs btn-success btn-sm"><i class="fa fa-thumbs-o-up"></i></span></a>
                  @else
                    <a href="" class="publish" data-value="{{ $key->id }}" data-toggle="modal" data-target=".modal-publish" title="Tidak Aktif"><span class="btn btn-xs btn-danger btn-sm"><i class="fa fa-thumbs-o-down"></i></span></a>
                  @endif
              </td>
              @endcan
              <td>
                @can('update-posisi')
                <a href="" class="ubah" data-value="{{ $key->id }}" data-toggle="modal" data-target=".modal-ubah"><span class="btn btn-xs btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fa fa-pencil"></i></span></a>
                @endcan
              </td>
            </tr>
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
<script src="{{ asset('vendors/select2/dist/js/select2.full.min.js')}}"></script>

<script type="text/javascript">
  $('#daftartabel').DataTable();

  $(".select2").select2({
    placeholder: "Pilih Bidang",
    allowClear: true
  });

  @can('update-posisi')
  $('#daftartabel').on('click','.ubah', function(){
    var a = $(this).data('value');
    $.ajax({
      url: "{{ url('/') }}/posisi/ubah/"+a,
      dataType: 'json',
      success: function(data){
        var id_posisi = data.id;
        var id_bidang = data.id_bidang;
        var kode_posisi = data.kode_posisi;
        var nama_posisi = data.nama_posisi;

        $('#id_posisi').attr('value', id_posisi);
        $('#edit_id_bidang').attr('value', id_bidang);
        $('#edit_kode_posisi').attr('value', kode_posisi);
        $('#edit_nama_posisi').attr('value', nama_posisi);
      }
    });
  });
  @endcan

  @can('publish-posisi')
  $('#daftartabel').on('click','.unpublish', function(){
    var a = $(this).data('value');
    $('#setUnpublish').attr('href', "{{ url('/') }}/posisi/publish/"+a);
  });

  $(function(){
    $('a.publish').click(function(){
      var a = $(this).data('value');
      $('#setPublish').attr('href', "{{ url('/') }}/posisi/publish/"+a);
    });
  });
  @endcan

</script>

@if($errors->has('edit_nama_posisi') || $errors->has('edit_deskripsi') || $errors->has('edit_kode_posisi'))
<script type="text/javascript">
  $('#modal-ubah').modal('show');
</script>
@endif
@endsection
