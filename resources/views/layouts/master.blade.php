
<!DOCTYPE html>
<html>
    @php
    use App\Company;
    $company = Company::first();
  @endphp
@include('layouts.partials.head')
<body class="hold-transition sidebar-mini layout-fixed  accent-warning">
<div class="se-pre-con"></div>

<div class="wrapper">

  <!-- Navbar -->
  @include('layouts.partials.navbar')
  <!-- /.navbar -->

    @include('layouts.partials.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        @yield('content-header')
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        @yield('content')
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</div>
<!-- ./wrapper -->

    @include('layouts.partials.script')

</body>
</html>
