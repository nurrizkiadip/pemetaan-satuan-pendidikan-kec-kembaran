@extends('admin.layouts.app')

@section('title', "Edit $school->name")

@section('styles')
  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin=""/>
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
          <li class="text-sm breadcrumb-item">
            <a href="{{ route('admin.village.show', [$village->id]) }}">
              Detail {{ $village->name }}
            </a>
          </li>
          <li class="breadcrumb-item active">Edit Sekolah {{ $school->name }}</li>
        </ol>
      </div>
    </div>
    <div class="row mb-2">
      <div class="col">
        <h1 class="m-0">Edit Sekolah {{ $school->name }}</h1>
      </div>
    </div>
  </div>
@endsection

@section('content')
	<div class="container-fluid">
		<div class="row">
			<section class="col-xl-6 col-md-8 col-sm-10 col-12">
				<form action="{{ route('admin.school.update', [$village->id, $school->id]) }}"
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
                value="{{ old('name', $school->name) }}"/>
            @error('name')
            <div class="invalid-feedback text-danger d-block">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="form-group">
            <label class="col-form-label" for="address">Alamat</label>
            <textarea
                id="address" name="address" rows="3" style="width: 100%"
                class="form-control @error('address') is-invalid @enderror"
                placeholder="Tulis disini..."
            >{{ old('address', $school->address) }}</textarea>
            @error('address')
            <div class="invalid-feedback text-danger d-block">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="row">
            <div class="col-lg-6 col-12">
              <div class="form-group">
                <label class="col-form-label" for="status">Status</label>
                <select
                    id="status" name="status"
                    class="form-control select2bs4 @error('status') is-invalid @enderror"
                    data-placeholder="Pilih...">
                  <option
                      {{ old('status', $school->status) === "NEGERI" ? 'selected' : '' }}
                      value="NEGERI">
                    NEGERI
                  </option>
                  <option
                      {{ old('status', $school->status) === "SWASTA" ? 'selected' : '' }}
                      value="SWASTA">
                    SWASTA
                  </option>
                </select>
                @error('status')
                <div class="invalid-feedback text-danger d-block">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            <div class="col-lg-6 col-12">
              <div class="form-group">
                <label class="col-form-label" for="school_level_id">Jenjang</label>
                <select
                    id="school_level_id" name="school_level_id" data-placeholder="Pilih..."
                    class="form-control select2bs4 @error('school_level_id') is-invalid @enderror"
                >
                  <option selected disabled value="">Pilih...</option>
                  @foreach($schoolLevels as $item)
                    <option
                        {{ (int)old('school_level_id', $school->school_level_id) === $item->id ? 'selected' : '' }}
                        value="{{ $item->id }}">
                      {{ $item->name }}
                    </option>
                  @endforeach
                </select>
                @error('school_level_id')
                <div class="invalid-feedback text-danger d-block">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
          </div>

          <div class="form-group">
            <label for="logo_photo_path">Logo</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="logo_photo_path" id="logo_photo_path" accept="image/*">
                <label class="custom-file-label" for="logo_photo_path">Pilih Berkas</label>
              </div>
              <div class="input-group-append">
                <span class="input-group-text">Unggah</span>
              </div>
            </div>
            @error('logo_photo_path')
            <div class="invalid-feedback text-danger d-block">
              {{ $message }}
            </div>
            @enderror
          </div>

          <label>Posisi Koordinat</label>
          <div class="row">
            <div class="col-md-6 col-12">
              <div class="form-group">
                <label for="lat">Latitude</label>
                <input type="text" value="{{ old('lat', $school->lat) }}" class="form-control" readonly name="lat" id="lat">
                @error('lat')
                <div class="invalid-feedback text-danger d-block">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
            <div class="col-md-6 col-12">
              <div class="form-group">
                <label for="lang">Longitude</label>
                <input type="text" value="{{ old('lang', $school->lang) }}" class="form-control" readonly name="lang" id="lang">
                @error('lang')
                <div class="invalid-feedback text-danger d-block">
                  {{ $message }}
                </div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col">
              <small class="text-muted">Lakukan pengambilan posisi menggunakan map dibawah ini</small>
              <div id="map" style="height: 500px"></div>
            </div>
          </div>

					<div class="form-group">
            <div class="d-flex justify-content-end align-items-center" style="gap: 1rem">
              <a href="{{ route('admin.village.show', [$village->id]) }}"
                 class="btn btn-danger text-uppercase">
                Batal
              </a>
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
  <!-- Leaflet -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
          integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
          crossorigin=""></script>
  <!-- Select2 -->
  <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

	<!-- Page specific script -->
	<script>
      $(function () {
          bsCustomFileInput.init();
      });
      $(document).ready(function () {
          const mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>';
          const mbUrl = 'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}';
          const accessToken = '{!! config('app.mb_access_token') !!}';

          const grayscale = L.tileLayer(mbUrl, {
              id: 'mapbox/light-v9',
              tileSize: 512,
              zoomOffset: -1,
              attribution: mbAttr,
              accessToken: accessToken
          });
          const streets = L.tileLayer(mbUrl, {
              id: 'mapbox/streets-v11',
              tileSize: 512,
              zoomOffset: -1,
              attribution: mbAttr,
              accessToken: accessToken
          });
          const satellite = L.tileLayer(mbUrl, {
              id: 'mapbox/satellite-v9',
              tileSize: 512,
              zoomOffset: -1,
              attribution: mbAttr,
              accessToken: accessToken
          });
          const openStreetMap = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
              attribution: "&copy; <a href=\"https://www.openstreetmap.org/copyright\">OpenStreetMap</a> contributors",
          });
          const dark = L.tileLayer(mbUrl, {
              id: 'mapbox/dark-v10',
              tileSize: 512,
              zoomOffset: -1,
              attribution: mbAttr,
              accessToken: accessToken
          });

          const baseMaps = {
              "<span style='color: gray'>Grayscale</span>": grayscale,
              "Streets": streets,
              "Satellite": satellite,
              "OpenStreetMap": openStreetMap,
              "Dark": dark,
          };
          // Define instance of map
          const map = L.map('map', {
              center: [{{$school->lat}}, {{$school->lang}}],
              zoom: 14,
              layers: [
                  openStreetMap,
              ]
          });
          const layerControl = L.control.layers(baseMaps).addTo(map);


          @if (Str::contains($school->name, '`'))
            const separateMsgPopup{{$school->id}} = [
                "{{\Str::before($school->name, '`')}}",
                "{{\Str::after($school->name, '`')}}",
            ];
            const villageName{{$school->id}} = separateMsgPopup{{$school->id}}[0] + separateMsgPopup{{$school->id}}[1];
          @else
            const villageName{{$school->id}} = "{{$school->name}}";
          @endif

          const msgPopup{{$school->id}} = `
              <table border="1">
              <tbody>
                  <tr>
                    <td class="text-bold">Nama</td>
                    <td>${villageName{{$school->id}}}</td>
                  </tr>
                  <tr>
                    <td class="text-bold">Jenjang</td>
                    <td>{{$school->schoolLevel->name}}</td>
                  </tr>
                  <tr>
                    <td class="text-bold">Status</td>
                    <td>{{$school->village->name}}</td>
                  </tr>
                  <tr>
                    <td class="text-bold">Status</td>
                    <td>{{$school->status}}</td>
                  </tr>
              </tbody>
              </table>
          `;

          const currentLocation = [{{ old('lat', $school->lat) }}, {{ old('lang', $school->lang) }}];
          map.attributionControl.setPrefix(false);
          const markerDraggable = new L.marker(currentLocation, {
              draggable: 'true'
          }).bindPopup(msgPopup{{$school->id}});

          map.addLayer(markerDraggable);

          markerDraggable.on('dragend', (event) => {
             $('#lat').val(event.target._latlng.lat);
             $('#lang').val(event.target._latlng.lng);
          });

          $('.select2').select2()

          //Initialize Select2 Elements
          $('.select2bs4').select2({
              theme: 'bootstrap4'
          });
      });
	</script>
@endsection
