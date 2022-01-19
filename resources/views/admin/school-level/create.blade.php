@extends('admin.layouts.app')

@section('title', "Edit Jenjang Sekolah ")

@section('styles')
@endsection

@section('content-header')
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col">
        <ol class="text-sm breadcrumb float-sm-right">
          <li class="text-sm breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">
              Dashboard
            </a>
          </li>
          <li class="breadcrumb-item active">Edit Jenjang Sekolah</li>
        </ol>
      </div>
    </div>
    <div class="row mb-2">
      <div class="col">
        <h1 class="m-0">Edit Jenjang Sekolah</h1>
      </div>
    </div>
  </div>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <section class="col-xl-6 col-md-8 col-sm-10 col-12">
        <form action="{{ route('admin.school-level.store') }}"
              method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          @if($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <h6>Pesan Error:</h6>
              <ul class="mb-0 pl-4">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif

          <div class="form-group">
            <label class="col-form-label" for="name">Nama</label>
            <input
                type="text" id="name" name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"/>
            @error('name')
            <div class="invalid-feedback text-danger d-block">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="icon">Ikon</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="icon" id="icon" accept="image/*">
                <label class="custom-file-label" for="icon">Pilih Berkas</label>
              </div>
              <div class="input-group-append">
                <span class="input-group-text">Unggah</span>
              </div>
            </div>
            @error('icon')
            <div class="invalid-feedback text-danger d-block">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group">
            <div class="d-flex justify-content-end align-items-center" style="gap: 1rem">
              <a href="{{ route('admin.dashboard') }}" class="btn btn-danger text-uppercase"
              >Batal</a>
              <button class="btn btn-primary text-uppercase" type="submit">Submit</button>
            </div>
          </div>
        </form>
      </section>
    </div>
  </div>
@endsection

@section('sidebar')
  @include('admin.layouts.sidebar')
@endsection

@section('scripts')
  <!-- bs-custom-file-input -->
  <script src="{{ asset('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

  <!-- Page specific script -->
  <script>
      $(function () {
          bsCustomFileInput.init();
      });
      $(document).ready(function () {

      });
  </script>
@endsection
