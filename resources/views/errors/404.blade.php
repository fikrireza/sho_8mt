@extends('layout.master')

@section('title')
  <title>| 404 Not Found</title>
@endsection

@section('content')

<div class="col-md-12">
  <div class="col-middle">
    <div class="text-center text-center">
      <h1 class="error-number">404</h1>
      <h2>Halaman atau data yang anda cari tidak ada. Silahkan hubungi Admin</h2>
      <br><br>
      <a href="{{ URL::previous() }}" class="btn btn-primary">Back</a>
    </div>
  </div>
</div>
@endsection
