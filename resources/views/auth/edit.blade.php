@extends('layouts.master')

@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.css')}}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endpush

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Profile User</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item">Profile User</li>
        <li class="breadcrumb-item active">Update</li>
      </ol>
    </div><!-- /.col -->
  </div><!-- /.row -->
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Update Profile</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Avatar</label>
                            <div class="col-sm-6 col-lg-6 col-md-6">
                                <img class="img-thumbnail" id="image_con" width="150px" src="{{asset('/uploads/'.$user->admin->avatar)}}" alt="">
                              <input type="file" class="form-control" id="image" name="avatar">
                            </div>
                          </div>
                        <div class="form-group row">
                          <label for="name" class="col-sm-2 col-form-label">name <span class="text-danger">*</span> </label>
                          <div class="col-sm-6 col-lg-6 col-md-6">
                            <input type="text" value="{{$user->admin->name}}" class="form-control" id="name" name="name" placeholder="name">
                          </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
                            <div class="col-sm-6 col-lg-6 col-md-6">
                                <input type="email" value="{{$user->email}}" class="form-control" id="email" name="email" placeholder="email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password <span class="text-danger">*</span></label>
                            <div class="col-sm-6 col-lg-6 col-md-6">
                                <input type="password" class="form-control" id="password" name="password" placeholder="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">Phone Number <span class="text-danger">*</span></label>
                            <div class="col-sm-6 col-lg-6 col-md-6">
                                <input type="text" value="{{$user->admin->phone}}" class="form-control" id="phone" name="phone" placeholder="phone">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">Address <span class="text-danger">*</span></label>
                            <div class="col-sm-6 col-lg-6 col-md-6">
                                <input type="text" value="{{$user->admin->address}}" class="form-control" id="address" name="address" placeholder="address">
                            </div>
                        </div>
                      </div>

                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                    <a href="{{route('profile.user')}}" class="btn btn-default">Back</a>
                  </div>
                  <!-- /.card-footer -->
                </form>
              </div>
              <!-- /.card -->
        </div>
</div>
@endsection

@push('script')
<!-- Select2 -->
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('#select-category').select2()
    $('#description').summernote()
  });
</script>
<script>
    //menampilkan foto setiap ada perubahan pada modal tambah
    $('#image').on('change', function() {
        readURL(this);
    });
        function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_con').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@endpush
