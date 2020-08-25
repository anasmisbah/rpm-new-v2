@extends('layouts.master')

@push('css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endpush

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Video</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('video.index')}}">Video</a></li>
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
                  <h3 class="card-title">Mengubah Video</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route('video.update',$video->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                  <div class="card-body">
                    <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">Judul</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input type="text" class="form-control  @error('title') is-invalid @enderror" value="{{old('title')?old('title'):$video->title}}" id="title" name="title" placeholder="Title video">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="url" class="col-sm-2 col-form-label">Url</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input type="url" class="form-control  @error('url') is-invalid @enderror" value="{{old('url')?old('url'):$video->url}}" id="url" name="url" placeholder="Url Video">
                            @error('url')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Gambar /  Sampul</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <img class="img-thumbnail" id="image_con" width="500" src="{{asset("/uploads/".$video->image)}}" alt=""><br>
                            <input type="file" id="image" class="form-control @error('image') is-invalid @enderror mt-2" id="image" name="image">
                            @error('image')
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
                    <a href="{{route('video.index')}}" class="btn btn-default">Kembali</a>
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
        const error = '{{ $errors->first() }}'
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

        if (error) {
            Toast.fire({
                type: 'error',
                title: 'Video update failed'
            })
        }
    });
</script>
@endpush
