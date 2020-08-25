@extends('layouts.master')

@push('css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endpush

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Agen {{$agen->name}}</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('agen.index')}}">Agen</a></li>
        <li class="breadcrumb-item"><a href="{{route('driver.agen.index',$agen->id)}}">Driver</a></li>
        <li class="breadcrumb-item active">Ubah</li>
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
                  <h3 class="card-title">Mengubah Driver Agen {{$agen->name}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route('driver.agen.update',$driver->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Nama <span class="text-danger">*</span> </label>
                            <div class="col-sm-6 col-lg-6 col-md-6">
                                <input type="text" value="{{old('name')?old('name'):$driver->name}}" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="name">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email Pengguna<span class="text-danger">*</span></label>
                            <div class="col-sm-6 col-lg-6 col-md-6">
                                <input type="email" value="{{old('email')?old('email'):$driver->user->email}}" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password Pengguna<span class="text-danger">*</span></label>
                            <div class="col-sm-6 col-lg-6 col-md-6">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="*********">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-2 col-form-label">Nomor Telepon<span class="text-danger">*</span></label>
                            <div class="col-sm-6 col-lg-6 col-md-6">
                                <input type="text" value="{{old('phone')?old('phone'):$driver->phone}}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="phone">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="route" class="col-sm-2 col-form-label">Rute / Jalur <span class="text-danger">*</span></label>
                            <div class="col-sm-6 col-lg-6 col-md-6">
                                <select class="form-control @error('route') is-invalid @enderror"  name="route" id="route">
                                    <option value="0" {{$driver->route == "0"?'selected':''}}>Jalur Darat</option>
                                    <option value="1" {{$driver->route == "1"?'selected':''}}>Jalur Laut</option>
                                </select>
                                @error('route')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">Alamat <span class="text-danger">*</span></label>
                            <div class="col-sm-6 col-lg-6 col-md-6">
                                <input type="text" value="{{old('address')?old('address'):$driver->address}}" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="address">
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Avatar</label>
                            <div class="col-sm-6 col-lg-6 col-md-6">
                                <img class="img-thumbnail mb-2" id="image_con" width="150px" src="{{asset('/uploads/'.$driver->avatar)}}" alt="">
                                <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="image" name="avatar">
                                @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                          </div>
                      </div>

                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" class="btn btn-info">Simpan</button>
                    <a href="{{route('driver.agen.index',$agen->id)}}" class="btn btn-default">Kembali</a>
                  </div>
                  <!-- /.card-footer -->
                </form>
              </div>
              <!-- /.card -->
        </div>
</div>
@endsection

@push('script')
<!-- SweetAlert2 -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js')}}"></script>
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
<script>
    $(function() {
        const status = '{{ Session("status") }}'

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        if (status) {
            Toast.fire({
                type: 'success',
                title: status
            })
        }

        const error = '{{ $errors->first() }}'
        if (error) {
            Toast.fire({
                type: 'error',
                title: 'Driver update failed'
            })
        }
    });
</script>
@endpush
