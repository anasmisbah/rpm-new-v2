@extends('layouts.master')

@push('css')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endpush

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0 text-dark">Promo</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('promo.index')}}">Promo</a></li>
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
                  <h3 class="card-title">Mengubah Promo</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route('promo.update',$promo->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                  <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{old('name')?old('name'):$promo->name}}" id="name" name="name" placeholder="name promo">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="point" class="col-sm-2 col-form-label">Poin yang dibutuhkan</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input type="number" class="form-control @error('point') is-invalid @enderror" value="{{old('point')?old('point'):$promo->point}}" id="point" name="point" placeholder="point">
                            @error('point')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="total" class="col-sm-2 col-form-label">Total Promo Tersedia</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input type="number" class="form-control @error('total') is-invalid @enderror" value="{{old('total')?old('total'):$promo->total}}" id="total" name="total" placeholder="total">
                            @error('total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description')?old('description'):$promo->description }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="terms" class="col-sm-2 col-form-label">Syarat & Ketentuan</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <textarea id="terms" class="form-control @error('terms') is-invalid @enderror" id="terms" name="terms">{{ old('terms')?old('terms'):$promo->terms }}</textarea>
                            @error('terms')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <select class="form-control @error('status') is-invalid @enderror"  name="status" id="status">
                                <option value="normal" {{$promo->status == "normal"?'selected':''}}>Normal</option>
                                <option value="hot" {{$promo->status == "hot"?'selected':''}}>Hot</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Gambar/Sampul</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <img class="img-thumbnail mb-2" id="image_con" width="150px" src="{{asset("/uploads/".$promo->image)}}" alt=""><br>
                            <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
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
                    <a href="{{route('promo.index')}}" class="btn btn-default">Kembali</a>
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
                title: 'Promo update failed'
            })
        }
    });
</script>
@endpush
