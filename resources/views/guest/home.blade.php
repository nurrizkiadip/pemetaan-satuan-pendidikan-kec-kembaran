@extends('guest.layouts.app')

@section('title', 'Beranda')

@section('styles')
  <!-- Leaflet -->
  {{--  <link href="{{ asset('leaflet/leaflet.css') }}">--}}
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
      const accessToken = 'pk.eyJ1IjoibnVycml6a2lhZGlwIiwiYSI6ImNrd2JuaG93dDE5eG8yd3AyZnhsdWN1MzAifQ.N-38M6Xh_0Tr5Y3t10SlpQ';

      //Add Layer Group
      // const cities = L.layerGroup();
      // const mLittleton = L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.').addTo(cities);
      // const mDenver = L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.').addTo(cities);
      // const mAurora = L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.').addTo(cities);
      // const mGolden = L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.').addTo(cities);


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
              streets,
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
      const separateMsgPopup{{$item->id}} = [
          "{{\Str::before($item->name, '`')}}",
          "{{\Str::after($item->name, '`')}}",
      ];
      const villageName{{$item->id}} = separateMsgPopup{{$item->id}}[0] + separateMsgPopup{{$item->id}}[1];
      @else
      const villageName{{$item->id}} = "{{$item->name}}";
      @endif

      const msgPopup{{$item->id}} = `
        <table border="1">
        <tbody>
          <tr>
            <td class="text-bold">Nama</td>
            <td>${villageName{{$item->id}}}</td>
          </tr>
          <tr>
            <td class="text-bold">Jenjang</td>
            <td>{{$item->schoolLevel->name}}</td>
          </tr>
          <tr>
            <td class="text-bold">Status</td>
            <td>{{$item->village->name}}</td>
          </tr>
          <tr>
            <td class="text-bold">Status</td>
            <td>{{$item->status}}</td>
          </tr>
        </tbody>
        </table>
      `;
      L.marker([{{$item->lat}}, {{$item->lang}}], {
          // icon: L.icon({
          //     iconSize:     [38, 95], // size of the icon
          //     shadowSize:   [50, 64], // size of the shadow
          //     iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
          //     shadowAnchor: [4, 62],  // the same for the shadow
          //     popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
          // })
      }).bindPopup(msgPopup{{$item->id}}).addTo(map);
      @endforeach

      const layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map);
  </script>
@endsection