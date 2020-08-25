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
        <li class="breadcrumb-item active">Tambah</li>
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
                  <h3 class="card-title">Menambah Promo</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route('promo.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                  <div class="card-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input value="{{old('name')}}" type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name Promo">
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
                            <input value="{{old('point')}}" type="number" class="form-control  @error('point') is-invalid @enderror" id="point" name="point" placeholder="point">
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
                            <input value="{{old('total')}}" type="number" class="form-control  @error('total') is-invalid @enderror" id="total" name="total" placeholder="total">
                            @error('total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="description" class="col-sm-2 col-form-label">Deksripsi</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <textarea id="description" placeholder="description promo" class="form-control  @error('description') is-invalid @enderror" id="description" name="description">{{old('description')}}</textarea>
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
                            <textarea id="terms" placeholder="Terms & Condition promo" class="form-control  @error('terms') is-invalid @enderror" id="terms" name="terms">{{old('terms')}}</textarea>
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
                            <select class="form-control  @error('status') is-invalid @enderror"  name="status" id="status">
                                <option value="normal" {{old('status') == 'normal'?'selected':''}}>Normal</option>
                                <option value="hot" {{old('status')== 'hot'?'selected':''}}>Hot</option>
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
                            <img class="img-thumbnail mb-2" id="image_con" width="150px" src="{{asset('/uploads/images/default.jpg')}}" alt="">
                            <input type="file" class="form-control  @error('image') is-invalid @enderror" id="image" name="image">
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
                title: 'Promo create failed'
            })
        }
    });
</script>
@endpush
