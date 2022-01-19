@extends('admin.layouts.app')

@section('title', 'Beranda')

@section('styles')
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content-header')
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <h1 class="m-0">Dashboard</h1>
      </div>
    </div>
  </div>
@endsection

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{$villagesCount}}</h3>

            <p>Kecamatan</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{$schools->count()}}</h3>

            <p>Satuan Pendidikan</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{$schools->where('status', 'NEGERI')->count()}}</h3>

            <p>Satuan Pendidikan Negeri</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{$schools->where('status', 'SWASTA')->count()}}</h3>

            <p>Satuan Pendidikan Swasta</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-6">
        <div class="card" id="jenjang-sekolah" style="min-height: 550px">
          <div class="card-header bg-gradient-lightblue">
            <h3 class="card-title">Daftar Jenjang Sekolah</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            @if (session()->has('status') && session()->has('message'))
              <div class="alert alert-{{session()->get('status')}} alert-dismissible fade show" role="alert">
                <span>{!!session()->get('message')!!}</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif

            <div class="card-tools mb-4 d-flex justify-content-end">
              <a href="{{ route('admin.school-level.create') }}"
                 class="btn btn-primary"
              ><i class="mr-2 fas fa-plus"></i>Jenjang Sekolah</a>
            </div>

            <div class="table-data table-responsive p-0" style="max-height: 400px">
              <table id="jenjang-sekolah-table" class="table table-sm table-bordered table-head-fixed table-hover">
                <thead>
                <tr>
                  <th class="text-center text-nowrap">No</th>
                  <th class="text-center text-nowrap">Nama</th>
                  <th class="text-center text-nowrap">Icon</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($schoolLevels as $schoolLevel)
                  <tr data-widget="expandable-table" aria-expanded="false">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $schoolLevel->name }}</td>
                    <td class="text-center">{{ $schoolLevel->icon ?? '-'}}</td>
                  </tr>
                  <tr class="expandable-body d-none">
                    <td colspan="3">
                      <h6 class="card-header bg-gradient-navy">Detail Sekolah Jenjang</h6>
                      <div class="text-center d-flex justify-content-end align-items-center" style="gap: .5rem">
                        <a href="{{ route('admin.school-level.edit', [$schoolLevel->id]) }}"
                           class="btn btn-sm btn-warning"
                        ><i class="mr-2 fas fa-pen"></i>Edit</a>
                        <div>
                          <a href="{{ route('admin.school-level.destroy', [$schoolLevel->id]) }}"
                             class="btn btn-sm btn-danger school-level-delete-btn"
                             data-schools-count="{{$schoolLevel->schools_count}}"
                             data-school-level-id="{{$schoolLevel->id}}"
                          ><i class="mr-2 fas fa-trash"></i>Delete</a>
                          <form action="{{ route('admin.school-level.destroy', [$schoolLevel->id]) }}"
                                method="post" class="d-none" id="school-level-delete-form-{{$schoolLevel->id}}">
                            @csrf
                            @method('DELETE')
                          </form>
                        </div>
                      </div>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <!-- SweetAlert2 -->
  <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

  <script type="text/javascript">
      $(document).ready(function () {
          /*SweetAlert2*/
          const ConfirmSwal2 = Swal.mixin({
              confirmButtonText: 'Ya', confirmButtonAriaLabel: 'Ya',
              showCancelButton: true, cancelButtonText: 'Kembali',
              cancelButtonAriaLabel: 'Kembali',
              showCloseButton: true,
              customClass: {
                  confirmButton: 'mx-1 btn btn-primary',
                  cancelButton: 'mx-1 btn btn-outline-danger'
              },
              buttonsStyling: false,
          });
          const AlertSwal2 = Swal.mixin({
              showCloseButton: true,
              customClass: {
                  confirmButton: 'mx-1 btn btn-primary',
                  cancelButton: 'mx-1 btn btn-outline-danger'
              },
              buttonsStyling: false,
          });

          /*Delete Unit Kerja*/
          $('#jenjang-sekolah #jenjang-sekolah-table .school-level-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "Kelurahan ini akan dihapus!",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          if ($($el).data().schoolsCount) {
                              AlertSwal2.fire({
                                  icon: 'error',
                                  title: 'Gagal Menghapus',
                                  text: "Maaf, Anda tidak bisa menghapus jenjang sekolah ini karena masih memiliki data sekolah.",
                              });
                          } else {
                              $(`#school-level-delete-form-${$($el).data().schoolLevelId}`).submit()
                          }
                      }
                  })
              });
          });
          /*SweetAlert2*/
      });
  </script>
@endsection