@extends('admin.layouts.app')

@section('title', 'Detail Kelurahan')

@section('styles')
	<!-- DataTables -->
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<link rel="stylesheet"
	      href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content-header')
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col">
				<ol class="text-sm breadcrumb float-sm-right">
          <li class="text-sm breadcrumb-item">
            <a href="{{ route('admin.village.index') }}">
              Daftar Kelurahan
            </a>
          </li>
          <li class="breadcrumb-item active">Detail {{$village->name}}</li>
				</ol>
			</div>
		</div>
		<div class="row mb-2">
			<div class="col">
				<h1 class="m-0">Detail {{ $village->name }}</h1>
			</div>
		</div>
	</div>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<section class="col" id="school-container">
				<div class="card">
					<div class="card-header bg-gradient-lightblue">
						<h3 class="card-title">Daftar Sekolah</h3>

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
            <div class="d-flex flex-row justify-content-end">
              <div class="mb-4">
                <a href="{{ route('admin.school.create', [$village->id]) }}"
                   class="btn btn-primary">
                  <i class="mr-2 fas fa-plus"></i>Sekolah
                </a>
              </div>
            </div>

						<table id="schools-table" style="width: 100%"
						       class="table table-sm table-striped table-bordered table-hover">
							<thead>
							<tr>
								<th class="text-center text-nowrap">No</th>
								<th class="text-center text-nowrap">Nama</th>
								<th class="text-center text-nowrap">Alamat</th>
								<th class="text-center text-nowrap">Status</th>
								<th class="text-center text-nowrap">Posisi</th>
								<th class="text-center text-nowrap">Dibuat pada</th>
								<th class="text-center text-nowrap">Aksi</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($schools as $item)
								<tr>
									<td class="text-center">{{ $loop->iteration }}</td>
									<td>{{ $item->name }}</td>
									<td class="">{{ $item->address }}</td>
									<td class="text-center">{{ $item->status }}</td>
									<td class="text-center">{{ "$item->lat, $item->lang"  }}</td>
									<td class="text-center">{{ parse_date_to_iso_format($item->created_at) }}</td>
									<td class="text-right d-flex justify-content-center align-items-center flex-wrap" style="gap: 0.5rem">
                    <a class="btn btn-warning btn-xs text-nowrap"
										   href="{{ route('admin.school.edit', [$village->id, $item->id]) }}">
											<i class="mr-2 fas fa-pencil-alt"></i>Edit
										</a>
                    <a class="btn btn-danger btn-xs text-nowrap school-delete-btn"
                       data-school-id="{{$item->id}}"
                       href="{{ route('admin.school.destroy', [$village->id, $item->id]) }}"
                    ><i class="mr-2 fas fa-trash"></i>Delete
                    </a>
                    <form id="school-delete-form-{{ $item->id }}" class="d-none" method="POST"
                          action="{{ route('admin.school.destroy', [$village->id, $item->id]) }}">
                      @csrf
                      @method("DELETE")
                    </form>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</section>
		</div>
	</div>
@endsection

@section('scripts')
	<!-- DataTables  & Plugins -->
	<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
	<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
  <!-- SweetAlert2 -->
  <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

	<!-- Page specific script -->
	<script>
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
          $('#school-container .school-delete-btn').each(function (idx, $el) {
              $($el).click(function ($event) {
                  $event.preventDefault();
                  ConfirmSwal2.fire({
                      icon: 'question',
                      title: 'Apakah anda yakin?',
                      text: "Sekolah ini akan dihapus!",
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $(`#school-delete-form-${$($el).data().schoolId}`).submit()
                      }
                  })
              });
          });
          /*SweetAlert2*/

          /*Datatables*/
          $('#schools-table').DataTable({
              "info": true,
              "autoWidth": true,
              "scrollX": true,
          });
          /*Datatables*/
      });
	</script>
@endsection
