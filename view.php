<?php
include 'koneksi.php';
$result = mysqli_query($conn, "SELECT * FROM view_keputusan_devitha");
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Keputusan</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('walpaper.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-attachment: fixed;
      margin: 0;
      padding: 0;
    }
    h2 {
      text-align: center;
      color: white;
      margin-top: 30px;
      text-shadow: 1px 1px 2px black;
    }
    table {
      margin: 30px auto;
      border-collapse: collapse;
      width: 90%;
      background-color: rgba(255, 255, 255, 0.95);
      box-shadow: 0 0 10px #333;
    }
    th, td {
      padding: 10px;
      border: 1px solid #aaa;
      text-align: center;
    }
    th {
      background-color: #2d6cdf;
      color: white;
    }
    td:last-child {
      font-weight: bold;
      color: #006400;
    }
  </style>
</head>
<body>

<h2>Hasil Keputusan</h2>

<table>
  <tr>
    <th>Nama</th>
    <th>Hardware</th>
    <th>Jaringan</th>
    <th>Penggunaan</th>
    <th>Keputusan</th>
  </tr>

  <?php while($d = mysqli_fetch_assoc($result)) : ?>
    <tr>
      <td><?= $d['nama']; ?></td>
      <td><?= $d['hardware']; ?></td>
      <td><?= $d['jaringan']; ?></td>
      <td><?= $d['penggunaan']; ?></td>
      <td><?= strtoupper($d['keputusan']); ?></td>
    </tr>
  <?php endwhile; ?>
</table>

<audio autoplay loop hidden>
  <source src="laguku.mp3" type="audio/mpeg">
</audio>

<a href="export_view_keputusan.php" target="_blank" style="padding: 8px 16px; background: green; color: white; text-decoration: none; border-radius: 5px;">Export ke Excel</a>

</body>
</html>
