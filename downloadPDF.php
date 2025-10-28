<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Laporan Harga Pangan</title>
  <style>
    body { font-family: sans-serif; font-size: 12px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    h2 { text-align: center; }
  </style>
</head>
<body>
  <h2>Laporan Harga Pangan Bulan <?= $bulan ?>/<?= $tahun ?></h2>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Komoditas</th>
        <th>Harga</th>
        <th>Satuan</th>
        <th>Wilayah</th>
        <th>Tanggal</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($riwayat as $i => $item): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= $item['nama_komoditas'] ?></td>
          <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
          <td><?= $item['satuan'] ?></td>
          <td><?= $item['nama_wilayah'] ?></td>
          <td><?= date('d-m-Y', strtotime($item['tanggal'])) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>
