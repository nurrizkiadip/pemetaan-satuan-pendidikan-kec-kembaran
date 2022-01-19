@extends('guest.layouts.app')

@section('title', 'Beranda')

@section('styles')
  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin=""/>
  <style>
      #map {
          height: 800px;
      }
  </style>
@endsection

@section('content-header')
  <div class="row mb-2">
    <div class="col">Pemetaan Satuan Pendidikan di Kecamatan Kembaran, Kabupaten Banyumas, Provinsi Jawa Tengah</div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col">
      <div id="map"></div>
    </div>
  </div>
@endsection


@section('scripts')
  <!-- Leaflet -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
          integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
          crossorigin=""></script>
  <script src="{{ asset('leaflet/leaflet.ajax.min.js') }}"></script>

  <script type="text/javascript">
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

      // Create Layer group for all kelurahan
      @foreach ($villages as $item)
      const village{{$item->id}}LayerGroup = L.layerGroup();
      @endforeach

      const baseMaps = {
          "<span style='color: gray'>Grayscale</span>": grayscale,
          "Streets": streets,
          "Satellite": satellite,
          "OpenStreetMap": openStreetMap,
          "Dark": dark,
      };
      const overlayMaps = {
        @foreach ($villages as $item)
        "{{ $item->name }}": village{{$item->id}}LayerGroup,
        @endforeach
      };

      // Define instance of map
      const map = L.map('map', {
          center: [-7.4146026, 109.287500],
          zoom: 14,
          layers: [
              openStreetMap,
              @foreach ($villages as $item)
              village{{$item->id}}LayerGroup,
              @endforeach
          ]
      });

      @foreach ($villages as $item)
      new L.GeoJSON.AJAX("{{ get_file_from_public_storage($item->geojson_path) }}", {
          onEachFeature: (feature, layer) => {
              if (feature.properties && feature.properties.desa)
                  layer.bindPopup(`<span style="font-weight: bold">Nama Desa</span>: ${feature.properties.desa}`);
          },
          style: {
              color: 'white',
              fillColor: "{{ $item->color }}",
              fillOpacity: .75
          }
      }).addTo(village{{$item->id}}LayerGroup);
      @endforeach

      @foreach ($schools as $item)

      @if (Str::contains($item->name, '`'))
        const villageName{{$item->id}} = "{{ \Str::replace('`', '\`', $item->name) }}";
      @else
        const villageName{{$item->id}} = "{{$item->name}}";
      @endif

      const msgPopup{{$item->id}} = `
        <p class="text-center text-sm text-bold text-uppercase">Detail Sekolah</p>
        <table>
        <tbody>
          @if (file_from_public_storage_exists($item->logo_photo_path))
            <tr>
                <td colspan="2" class="text-bold"><img src="{{ get_file_from_public_storage($item->logo_photo_path) }}" width="100%"></td>
            </tr>
          @endif
          <tr>
            <td class="text-bold">Nama</td>
            <td>: ${villageName{{$item->id}}}</td>
          </tr>
          <tr>
            <td class="text-bold">Jenjang</td>
            <td>: {{$item->schoolLevel->name}}</td>
          </tr>
          <tr>
            <td class="text-bold">Status</td>
            <td>: {{$item->village->name}}</td>
          </tr>
          <tr>
            <td class="text-bold">Status</td>
            <td>: {{$item->status}}</td>
          </tr>
        </tbody>
        </table>
      `;
      L.marker([{{$item->lat}}, {{$item->lang}}], {
          @if ($item->schoolLevel->icon !== null)
              icon: L.icon({
              iconUrl: '{{ get_file_from_public_storage($item->schoolLevel->icon) }}',

              iconSize:     [30, 37.5], // size of the icon
              shadowSize:   [50, 64], // size of the shadow
              iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
              shadowAnchor: [4, 62],  // the same for the shadow
              popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
          })
          @endif
      }).bindPopup(msgPopup{{$item->id}}).addTo(map);
      @endforeach

      const layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map);
  </script>
@endsection