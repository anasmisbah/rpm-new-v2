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
      <h1 class="m-0 text-dark">Event</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{route('event.index')}}">Event</a></li>
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
                  <h3 class="card-title">Mengubah Event</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{route('event.update',$event->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                  <div class="card-body">
                    <div class="form-group row">
                        <label for="title" class="col-sm-2 col-form-label">Nama  <span class="text-danger">*</span></label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" value="{{old('title')?old('title'):$event->title}}" id="title" name="title" placeholder="title">
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="image" class="col-sm-2 col-form-label">Gambar / SAmpul</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <img class="img-thumbnail mb-2" id="image_con" width="150px" src="{{asset("/uploads/".$event->image)}}" alt="">
                            <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                          <select class="select2 @error('category') is-invalid @enderror" id="select-category" multiple="multiple" name="category[]" data-placeholder="Select Category" style="width: 100%;">
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                          </select>
                          @error('category')
                          <span class="text-sm text-danger" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                          @enderror
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="startdate" class="col-sm-2 col-form-label">Tanggal Mulai <span class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <div class="input-group date" id="startdate" data-target-input="nearest">
                                <input value="{{old('startdate')?old('startdate'):$event->startdate}}" type="text" class="form-control @error('startdate') is-invalid @enderror datetimepicker-input" data-target="#startdate" name="startdate"/>
                                <div class="input-group-append" data-target="#startdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @error('startdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="enddate" class="col-sm-2 col-form-label">Tanggal Berakhir <span class="text-danger">*</span> </label>
                        <div class="col-sm-6 col-lg-6 col-md-6">
                            <div class="input-group date" id="enddate" data-target-input="nearest">
                                <input value="{{old('enddate')?old('enddate'):$event->enddate}}" type="text" class="form-control @error('enddate') is-invalid @enderror datetimepicker-input" data-target="#enddate" name="enddate"/>
                                <div class="input-group-append" data-target="#enddate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                @error('enddate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                      <div class="form-group row">
                        <label for="description" class="col-sm-2 col-form-label">Deskripsi  <span class="text-danger">*</span></label>
                        <div class="col-sm-12 col-lg-10 col-md-10">
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" id="description" name="description">{!! old('description')?old('description'):$event->description !!}</textarea>
                            @error('description')
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
                    <a href="{{route('event.index')}}" class="btn btn-default">Kembali</a>
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
<script src="{{asset('plugins/moment/moment.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('#select-category').select2().val({!! json_encode($event->category()->allRelatedIds()) !!}).trigger('change')
    $('#description').summernote()
    $('#startdate').datetimepicker({
            format: 'L',
            format: 'YYYY-MM-D'
    });
    $('#enddate').datetimepicker({
            format: 'L',
            format: 'YYYY-MM-D'
    });
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
                title: 'Event update failed'
            })
        }
    });
</script>
@endpush
