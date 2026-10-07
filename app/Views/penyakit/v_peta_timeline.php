<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
  #map {
    height: 560px;
    width: 100%;
    border-radius: 6px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  }
  .legend-box {
    background: white;
    padding: 10px 14px;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    font-size: 12px;
    line-height: 20px;
  }
  .legend-color {
    width: 14px;
    height: 14px;
    display: inline-block;
    border-radius: 3px;
    margin-right: 6px;
    vertical-align: middle;
  }
  .timeline-control-panel {
    background: #ffffff;
    border-radius: 8px;
    padding: 12px 18px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.07);
    border: 1px solid #e2e8f0;
  }
  .timeline-slider {
    width: 100%;
    cursor: pointer;
  }
  .timeline-month-badge {
    font-size: 15px;
    font-weight: 700;
    color: #184c78;
    background: #e9f2f9;
    padding: 4px 14px;
    border-radius: 20px;
  }
  .leaflet-popup-content {
    min-width: 240px;
    font-size: 13px;
    line-height: 1.5;
  }
  .leaflet-popup-content h6 {
    font-weight: bold;
    color: #184c78;
    margin-bottom: 6px;
    border-bottom: 1px solid #eee;
    padding-bottom: 4px;
  }
</style>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark font-weight-bold"><i class="fa-solid fa-map-location-dot text-primary mr-2"></i>Peta Surveilans Penyakit (Timeline)</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Peta Penyakit</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <!-- KPI STATISTIC CARDS -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3 id="stat-aktif">0</h3>
            <p>Kasus Aktif (Wabah)</p>
          </div>
          <div class="icon">
            <i class="fa-solid fa-biohazard"></i>
          </div>
          <a href="<?= base_url('penyakit/kasus') ?>" class="small-box-footer">Lihat Rincian <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3 id="stat-sembuh">0</h3>
            <p>Total Ternak Sembuh</p>
          </div>
          <div class="icon">
            <i class="fa-solid fa-shield-heart"></i>
          </div>
          <a href="<?= base_url('penyakit/kasus') ?>" class="small-box-footer">Lihat Rincian <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-dark">
          <div class="inner">
            <h3 id="stat-mati">0</h3>
            <p>Kematian Ternak/Unggas</p>
          </div>
          <div class="icon">
            <i class="fa-solid fa-skull-crossbones"></i>
          </div>
          <a href="<?= base_url('penyakit/kasus') ?>" class="small-box-footer">Lihat Rincian <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3 id="stat-desa-tertular">0</h3>
            <p>Desa Zona Merah/Kuning</p>
          </div>
          <div class="icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
          </div>
          <a href="<?= base_url('penyakit/kasus') ?>" class="small-box-footer">Lihat Rincian <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>

    <!-- FILTER TOOLBAR -->
    <div class="card card-outline card-primary shadow-sm mb-3">
      <div class="card-body p-3">
        <div class="row align-items-center">
          <div class="col-md-3 mb-2 mb-md-0">
            <label class="mb-1 font-weight-bold text-muted small"><i class="fa-solid fa-cow mr-1"></i> Komoditas Ternak:</label>
            <select id="filter-komoditas" class="form-control form-control-sm">
              <option value="all">-- Semua Komoditas --</option>
              <?php foreach ($komoditas_list as $kom): ?>
                <option value="<?= $kom ?>"><?= $kom ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-4 mb-2 mb-md-0">
            <label class="mb-1 font-weight-bold text-muted small"><i class="fa-solid fa-virus mr-1"></i> Jenis Penyakit (PHMS):</label>
            <select id="filter-penyakit" class="form-control form-control-sm">
              <option value="all">-- Semua Penyakit PHMS --</option>
              <?php foreach ($penyakit_list as $pen): ?>
                <option value="<?= $pen->id_penyakit ?>"><?= $pen->kode_penyakit ?> - <?= $pen->nama_penyakit ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-2 mb-2 mb-md-0">
            <label class="mb-1 font-weight-bold text-muted small"><i class="fa-solid fa-calendar-days mr-1"></i> Tahun:</label>
            <select id="filter-tahun" class="form-control form-control-sm">
              <?php for ($y = date('Y'); $y >= 2024; $y--): ?>
                <option value="<?= $y ?>" <?= ($y == $current_year) ? 'selected' : '' ?>><?= $y ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="col-md-3 text-md-right mt-2 mt-md-0">
            <a href="<?= base_url('penyakit/kasus_add') ?>" class="btn btn-danger btn-sm shadow-sm font-weight-bold">
              <i class="fa-solid fa-plus-circle mr-1"></i> Input Laporan Kasus
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- MAP CONTAINER & TIMELINE CONTROLLER -->
    <div class="card shadow-sm border-0">
      <div class="card-body p-2">
        <div id="map"></div>
      </div>
      <div class="card-footer bg-white border-top">
        <div class="timeline-control-panel">
          <div class="row align-items-center">
            <div class="col-md-4 mb-2 mb-md-0 d-flex align-items-center">
              <button id="btn-play" class="btn btn-primary btn-sm mr-2" title="Putar Animasi Timeline">
                <i class="fa-solid fa-play mr-1"></i> Play
              </button>
              <button id="btn-prev" class="btn btn-outline-secondary btn-sm mr-1" title="Bulan Sebelumnya">
                <i class="fa-solid fa-backward-step"></i>
              </button>
              <button id="btn-next" class="btn btn-outline-secondary btn-sm mr-3" title="Bulan Berikutnya">
                <i class="fa-solid fa-forward-step"></i>
              </button>
              <span id="label-periode" class="timeline-month-badge">Oktober 2026</span>
            </div>
            <div class="col-md-6 mb-2 mb-md-0">
              <input type="range" id="timeline-slider" class="custom-range timeline-slider" min="1" max="12" step="1" value="<?= $current_month ?>">
              <div class="d-flex justify-content-between text-muted small font-weight-bold mt-1">
                <span>Jan</span><span>Feb</span><span>Mar</span><span>Apr</span><span>Mei</span><span>Jun</span>
                <span>Jul</span><span>Agu</span><span>Sep</span><span>Okt</span><span>Nov</span><span>Des</span>
              </div>
            </div>
            <div class="col-md-2 text-md-right">
              <label class="small text-muted mb-0 mr-1">Speed:</label>
              <select id="playback-speed" class="form-control form-control-sm d-inline-block" style="width: 75px;">
                <option value="2000">1x</option>
                <option value="1200">2x</option>
                <option value="600">5x</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
  // Inisialisasi Peta Leaflet (Kabupaten Sinjai)
  const map = L.map('map').setView([-5.2500, 120.1400], 11);

  // Basemap Tile Layer
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '&copy; Dinas Peternakan & Keswan Sinjai'
  }).addTo(map);

  // Legenda Zonasi
  const legend = L.control({position: 'bottomright'});
  legend.onAdd = function (map) {
    const div = L.DomUtil.create('div', 'legend-box');
    div.innerHTML = `
      <div class="font-weight-bold mb-1 border-bottom pb-1">Status Zonasi Kasus</div>
      <div><span class="legend-color" style="background:#dc3545;"></span> Zona Merah (Aktif &ge; 5)</div>
      <div><span class="legend-color" style="background:#ffc107;"></span> Zona Kuning (Aktif 1-4)</div>
      <div><span class="legend-color" style="background:#28a745;"></span> Zona Hijau (0 Kasus / Bebas)</div>
    `;
    return div;
  };
  legend.addTo(map);

  let geojsonLayer = null;
  const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
  let isPlaying = false;
  let playInterval = null;

  // Parser WKT (Well-Known Text) sederhana ke koordinat Leaflet Polygon/MultiPolygon
  function parseWKT(wktString) {
    if (!wktString) return null;
    wktString = wktString.trim();
    
    // POLYGON (((lng lat, lng lat, ...)))
    if (wktString.startsWith("POLYGON")) {
      const match = wktString.match(/\(\((.*?)\)\)/s);
      if (match && match[1]) {
        const rings = match[1].split(",");
        const coords = [];
        for (let pair of rings) {
          const parts = pair.trim().split(/\s+/);
          if (parts.length >= 2) {
            const lng = parseFloat(parts[0]);
            const lat = parseFloat(parts[1]);
            if (!isNaN(lat) && !isNaN(lng)) {
              coords.push([lat, lng]);
            }
          }
        }
        return [coords];
      }
    }
    // MULTIPOLYGON ((((...)), ((...))))
    else if (wktString.startsWith("MULTIPOLYGON")) {
      const polyStrings = wktString.replace("MULTIPOLYGON", "").trim();
      const matches = polyStrings.match(/\(\(\((.*?)\)\)\)/g);
      if (matches) {
        const multiCoords = [];
        for (let m of matches) {
          const inner = m.replace(/\(\(\(/g, "").replace(/\)\)\)/g, "");
          const rings = inner.split(",");
          const coords = [];
          for (let pair of rings) {
            const parts = pair.trim().split(/\s+/);
            if (parts.length >= 2) {
              const lng = parseFloat(parts[0]);
              const lat = parseFloat(parts[1]);
              if (!isNaN(lat) && !isNaN(lng)) {
                coords.push([lat, lng]);
              }
            }
          }
          if (coords.length > 0) multiCoords.push(coords);
        }
        return multiCoords;
      }
    }
    return null;
  }

  // Fungsi memuat data GeoJSON Spasio-Temporal
  function loadMapData() {
    const tahun       = document.getElementById('filter-tahun').value;
    const bulan       = document.getElementById('timeline-slider').value;
    const id_penyakit = document.getElementById('filter-penyakit').value;
    const komoditas   = document.getElementById('filter-komoditas').value;

    document.getElementById('label-periode').innerText = monthNames[bulan - 1] + " " + tahun;

    const url = `<?= base_url('penyakit/api_timeline_geojson') ?>?tahun=${tahun}&bulan=${bulan}&id_penyakit=${id_penyakit}&komoditas=${komoditas}`;

    fetch(url)
      .then(res => res.json())
      .then(data => {
        // Update KPI Cards
        document.getElementById('stat-aktif').innerText = data.metadata.total_kasus_aktif || 0;
        document.getElementById('stat-sembuh').innerText = data.metadata.total_sembuh || 0;
        document.getElementById('stat-mati').innerText = data.metadata.total_mati || 0;

        let desaTertular = 0;

        if (geojsonLayer) {
          map.removeLayer(geojsonLayer);
        }

        geojsonLayer = L.featureGroup();

        data.features.forEach(feature => {
          const props = feature.properties;
          if (props.kasus_aktif > 0) desaTertular++;

          const latLngs = parseWKT(feature.wkt);
          if (latLngs && latLngs.length > 0) {
            const polygon = L.polygon(latLngs, {
              color: '#333333',
              weight: 1,
              fillColor: props.color,
              fillOpacity: props.fillOpacity
            });

            // Pop-up Detail Kasus
            let rincianHtml = "";
            if (props.daftar_kasus && props.daftar_kasus.length > 0) {
              rincianHtml += "<ul class='pl-3 mb-2 text-danger font-weight-bold'>";
              props.daftar_kasus.forEach(k => {
                rincianHtml += `<li>${k.penyakit} (${k.komoditas}): ${k.aktif} Sakit / Aktif</li>`;
              });
              rincianHtml += "</ul>";
            } else {
              rincianHtml = "<p class='text-success small mb-2'><i class='fa-solid fa-circle-check mr-1'></i>Tidak ada kasus aktif di periode ini.</p>";
            }

            const popupContent = `
              <div>
                <h6>📍 ${props.desa_nama} <small class="text-muted">(${props.kecamatan_nama})</small></h6>
                <div class="mb-2">
                  <span class="badge ${props.zonasi === 'Merah' ? 'badge-danger' : (props.zonasi === 'Kuning' ? 'badge-warning' : 'badge-success')}">
                    Zona ${props.zonasi} (Aktif: ${props.kasus_aktif} Ekor)
                  </span>
                </div>
                ${rincianHtml}
                <div class="small text-muted border-top pt-1">
                  <span>Sembuh: <b>${props.total_sembuh}</b> | Mati: <b>${props.total_mati}</b></span>
                </div>
              </div>
            `;

            polygon.bindPopup(popupContent);
            polygon.on('mouseover', function () {
              this.setStyle({ weight: 2.5, color: '#ffffff' });
            });
            polygon.on('mouseout', function () {
              this.setStyle({ weight: 1, color: '#333333' });
            });

            geojsonLayer.addLayer(polygon);
          }
        });

        document.getElementById('stat-desa-tertular').innerText = desaTertular;
        geojsonLayer.addTo(map);
      })
      .catch(err => console.error("Gagal memuat data spasial:", err));
  }

  // Event Listeners Filter & Slider
  document.getElementById('timeline-slider').addEventListener('input', loadMapData);
  document.getElementById('filter-tahun').addEventListener('change', loadMapData);
  document.getElementById('filter-penyakit').addEventListener('change', loadMapData);
  document.getElementById('filter-komoditas').addEventListener('change', loadMapData);

  document.getElementById('btn-prev').addEventListener('click', function () {
    const slider = document.getElementById('timeline-slider');
    let val = parseInt(slider.value) - 1;
    if (val < 1) val = 12;
    slider.value = val;
    loadMapData();
  });

  document.getElementById('btn-next').addEventListener('click', function () {
    const slider = document.getElementById('timeline-slider');
    let val = parseInt(slider.value) + 1;
    if (val > 12) val = 1;
    slider.value = val;
    loadMapData();
  });

  // Play / Pause Animation
  const btnPlay = document.getElementById('btn-play');
  btnPlay.addEventListener('click', function () {
    if (isPlaying) {
      clearInterval(playInterval);
      isPlaying = false;
      btnPlay.innerHTML = '<i class="fa-solid fa-play mr-1"></i> Play';
      btnPlay.classList.replace('btn-warning', 'btn-primary');
    } else {
      isPlaying = true;
      btnPlay.innerHTML = '<i class="fa-solid fa-pause mr-1"></i> Pause';
      btnPlay.classList.replace('btn-primary', 'btn-warning');

      const speed = parseInt(document.getElementById('playback-speed').value) || 2000;
      playInterval = setInterval(function () {
        const slider = document.getElementById('timeline-slider');
        let val = parseInt(slider.value) + 1;
        if (val > 12) val = 1;
        slider.value = val;
        loadMapData();
      }, speed);
    }
  });

  // Initial Load
  document.addEventListener('DOMContentLoaded', loadMapData);
</script>
