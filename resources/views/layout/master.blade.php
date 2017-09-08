<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@yield('title')
@include('includes.head')

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">

        @include('includes.sidebar')

        @include('includes.header')

        <!-- page content -->
        <div class="right_col" role="main">
        @yield('content')
        </div>

        <footer>
          @include('includes.footer')
        </footer>
      </div>
    </div>


    @include('includes.bottomscript')
    @yield('script')
  </body>
</html>
