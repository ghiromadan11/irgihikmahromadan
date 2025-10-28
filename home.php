<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #dcdcdc;
    }

    .sidebar {
      background-color: #ffffff;
      color: #000000;
      min-height: 100vh;
      padding: 1rem;
      border-right: 1px solid #ddd;
    }

    .sidebar a {
      color: #000000;
      text-decoration: none;
      display: block;
      margin: 1rem 0;
    }

    .sidebar a:hover {
      background-color: #f0f0f0;
      padding-left: 10px;
      transition: 0.3s;
    }

    .sidebar-logo {
      border-bottom: 2px solid #ccc;
      padding-bottom: 1rem;
      margin-bottom: 1rem;
    }

    .topbar {
      background-color: #028a0f;
      color: white;
      padding: 1rem 1.5rem;
      line-height: 1.3;
      position: relative;
      z-index: 10;
    }

    .dropdown-toggle {
      border: 1px solid white;
      padding: 4px 12px;
      background-color: transparent;
      color: white;
      border-radius: 20px;
      font-size: 0.9rem;
    }

    .scrolling-container {
      width: 100%;
      overflow: hidden;
      position: relative;
      height: 24px;
    }

    .scrolling-text {
      display: inline-block;
      white-space: nowrap;
      animation: scroll-left 15s linear infinite;
      font-size: 1.2rem;
      font-weight: bold;
      color: white;
    }

    @keyframes scroll-left {
      0% { transform: translateX(100%); }
      100% { transform: translateX(-100%); }
    }

    .card {
      background-color: #d4f6da;
      cursor: pointer;
      transition: transform 0.2s ease;
      border-radius: 14px;
    }

    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>
<body>
  <div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar collapse d-md-block" id="sidebarMenu">
      <div class="sidebar-logo text-center">
        <img src="<?= base_url('assets/Kabupatensukabumi.png') ?>" alt="logo" class="img-fluid mb-2" width="100">
      </div>
        <h5 class="fw-bold">EWS Sukabumi</h5>
          <a href="<?= base_url('user/home') ?>">🏠 Rumah</a>
          <a href="<?= base_url('user/unduh') ?>">⬇️ Unduh</a>
         
        <hr>
        <p style="font-size: 0.85rem;">Platform ini dirancang untuk memberikan informasi waktu nyata tentang fluktuasi harga pangan....</p>
      </div>

      <!-- Main Content -->
      <div class="col-md-10 d-flex flex-column px-0" style="min-height: 100vh;">
  <!-- Topbar -->
  <div class="topbar d-flex justify-content-between align-items-center px-4">
    <div class="scrolling-container w-100">
      <div class="scrolling-text">
        Selamat datang di Situs Web Sistem Informasi - Pemantauan Harga Pangan Kabupaten Sukabumi
      </div>
    </div>
    <div class="d-flex align-items-center gap-2">
    <!-- Tombol Login untuk Admin/Kepala -->
<a href="<?= base_url('login/force') ?>" class="btn btn-light border-0 shadow-sm d-flex align-items-center gap-2 px-3 py-1 rounded-pill">
  <i class="bi bi-person-fill fs-5 text-success"></i>
  <span class="fw-semibold text-dark">Login</span>
</a>
    </div>
  </div>

  <!-- Banner -->
  <div>
    <img src="<?= base_url('assets/benner.jpg') ?>" alt="banner" class="img-fluid w-100" style="height: 250px; object-fit: cover;">
  </div>


         <!-- Komoditas Section -->
      <div class="container mt-5">
        <div class="p-4 rounded shadow-sm border border-2 bg-white" style="border-color: #e0e0e0;">
          <h1 class="text-center fw-bold mb-3 text-success">Daftar Harga Komoditas Pangan</h1>
          <p class="text-center text-muted mb-4">
            Untuk melihat tren harga, klik salah satu komoditas pangan untuk menampilkan diagram batang naik atau turunnya harga secara harian atau pertanggal.
          </p>
          <hr class="my-4" style="border-top: 2px solid #ddd;">

          <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php if (!empty($komoditas)): ?>
              <?php foreach ($komoditas as $item): ?>
                <?php
                  $warna = '#81eb57ff'; 
                  if ($item['trend'] === 'naik') {
                     $warna = '#f19494ff';
                  } elseif ($item['trend'] === 'turun') {
                      $warna = '#60b3f8ff'; 
                  }
                ?>
                <div class="col">
                  <div class="card h-100 p-3 shadow-sm position-relative border-0"
                       style="cursor:pointer; background-color:<?= $warna ?>; transition: all 0.2s ease-in-out;"
                       onclick="tampilkanGrafik(<?= $item['komoditas_id'] ?>, '<?= addslashes($item['nama_komoditas']) ?>')">

                    <!-- Gambar dan Info -->
                    <div class="d-flex align-items-center mb-2">
                      <img src="<?= base_url('assets/img/harga_pangan/' . ($item['gambar'] ?? 'default.png')) ?>"
                           alt="<?= $item['nama_komoditas'] ?>"
                           class="me-3"
                           style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                      <div>
                        <h6 class="mb-1 fw-semibold"><?= esc($item['nama_komoditas']) ?></h6>
                        <p class="mb-1">Rp <?= number_format($item['harga'], 0, ',', '.') ?> / <?= esc($item['satuan']) ?></p>
                        <small class="text-muted">Standar: Rp <?= number_format($item['standar_harga'], 0, ',', '.') ?></small>
                        <small class="text-muted d-block">Tanggal: <?= date('d-m-Y', strtotime($item['tanggal'])) ?></small>
                        <small class="text-muted">Wilayah: <?= esc($item['nama_wilayah']) ?></small>
                      </div>
                    </div>

                    <!-- Persentase -->
                  <div class="text-center mt-auto pt-2 border-top" style="font-size: 0.85rem;">
                    <?php if ($item['trend'] === 'naik'): ?>
                      <span class="text-danger fw-bold">🔺 Naik <?= number_format($item['persentase'], 1) ?>%</span>
                    <?php elseif ($item['trend'] === 'turun'): ?>
                      <span class="text-success fw-bold">🔻 Turun <?= number_format($item['persentase'], 1) ?>%</span>
                    <?php else: ?>
                      <span class="text-muted fw-semibold">Stabil</span>
                    <?php endif; ?>

                    <br>
                    
                    <!-- Perbandingan Standar Harga -->
                    <?php if (isset($item['standar_harga']) && $item['standar_harga'] > 0): ?>
                      <?php if ($item['harga'] > $item['standar_harga']): ?>
                        <span class="badge bg-danger mt-1">Di Atas Standar</span>
                      <?php elseif ($item['harga'] < $item['standar_harga']): ?>
                        <span class="badge bg-primary mt-1">Di Bawah Standar</span>
                      <?php else: ?>
                        <span class="badge bg-success mt-1">✅ Sesuai Standar</span>
                      <?php endif; ?>
                    <?php else: ?>
                      <span class="badge bg-secondary mt-1">Standar Belum Ditentukan</span>
                    <?php endif; ?>
                  </div>

                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="col-12">
                <div class="alert alert-warning text-center">Data harga komoditas belum tersedia.</div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Modal Grafik -->
            <div class="modal fade" id="grafikModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content p-4 position-relative">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
            <h5 id="modalTitle" class="fw-bold mb-3 text-center"></h5>

            <div id="keteranganStandar" class="text-center fw-bold text-danger mb-2"></div>

            <!-- Grafik -->
            <canvas id="grafikHarga" height="120"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.4.0"></script>

<script>
let chart;
function tampilkanGrafik(komoditas_id, nama_komoditas) {
  fetch("<?= base_url('riwayat/grafik') ?>/" + komoditas_id)
    .then(res => res.json())
    .then(data => {
      if (!data || data.length === 0) {
        alert('Data tidak tersedia');
        return;
      }

      if (chart) chart.destroy();

      // Ambil 7 data terbaru (dari yang paling baru)
      const dataTerbaru = data.slice(0, 7);

      const tanggal = dataTerbaru.map(d => d.tanggal);
      const harga = dataTerbaru.map(d => d.harga);
      const standarHarga = parseFloat(dataTerbaru[0]?.standar_harga || 0);

      // Warna batang berdasarkan standar
      const warnaBar = harga.map(h => {
        const hargaAngka = parseFloat(h);
        return hargaAngka > standarHarga
          ? 'rgba(255, 99, 132, 0.8)' // merah
          : 'rgba(76, 175, 80, 0.8)'; // hijau
      });

      // Garis standar
      const garisStandar = new Array(harga.length).fill(standarHarga);

      // Tampilkan keterangan harga standar di tengah atas
      document.getElementById("keteranganStandar").textContent =
        "Standar Harga: Rp " + standarHarga.toLocaleString('id-ID');

      const ctx = document.getElementById('grafikHarga').getContext('2d');
      chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: tanggal,
          datasets: [
            {
              label: 'Harga Pangan',
              data: harga,
              backgroundColor: warnaBar,
              borderRadius: 4
            },
            {
              label: 'Standar Harga',
              data: garisStandar,
              type: 'line',
              borderColor: 'red',
              borderWidth: 2,
              borderDash: [6, 6],
              pointRadius: 0,
              fill: false
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              labels: {
                filter: (legendItem) => legendItem.datasetIndex === 1
              }
            },
            annotation: {
              annotations: {
                standarText: {
                  type: 'label',
                  xValue: 0,
                  yValue: standarHarga,
                  backgroundColor: 'transparent',
                  color: 'red',
                  font: {
                    weight: 'bold',
                    size: 12
                  },
                  xAdjust: -60,
                  yAdjust: -10,
                  position: 'start'
                }
              }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return 'Rp ' + value.toLocaleString('id-ID');
                }
              }
            }
          }
        },
        plugins: [Chart.registry.getPlugin('annotation')]
      });

      document.getElementById("modalTitle").textContent = nama_komoditas;
      new bootstrap.Modal(document.getElementById('grafikModal')).show();
    });
}
</script>
</body>
</html>
