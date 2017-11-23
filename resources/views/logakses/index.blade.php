@extends('layout.master')

@section('title')
  <title>BMT Ta'Awun | Log Akses</title>
@endsection

@section('headscript')
<link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')


<div class="page-title">
  <div class="title_left">
    <h3>Log Akses</h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Log Akses</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <form class="form-inline text-center">
          <select name="tahun" class="form-control select_tahun" onchange="this.form.submit()">
            <option value="">Pilih Tahun</option>
            <option value="2016" {{ $request == '2016' ? 'selected=""' : ''}}>2016</option>
            <option value="2017" {{ $request == '2017' ? 'selected=""' : ''}}>2017</option>
            <option value="2018" {{ $request == '2018' ? 'selected=""' : ''}}>2018</option>
            <option value="2019" {{ $request == '2019' ? 'selected=""' : ''}}>2019</option>
          </select>
        </form>
        <div class="ln_solid"></div>

        <table id="logtabel" class="table table-striped table-bordered" width="100%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Aksi</th>
              <th>Aktor</th>
              <th>BMT</th>
              <th>Waktu</th>
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getLog as $key)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $key->aksi }}</td>
              <td>{{ $key->aktor->name }}</td>
              <td>{{ $key->aktor->bmt->nama_bmt or 'Administrator' }}</td>
              <td>{{ $key->created_at }}</td>
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
  $(".select_tahun").select2({
    placeholder: "Pilih Tahun",
    allowClear: true
  });

  $('#logtabel').DataTable({
    "ordering": false,
    "pageLength": 50
  });

</script>
@endsection
