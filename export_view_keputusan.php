<?php
include 'koneksi.php';

header("Content-Type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=hasil_keputusan_view.xls");

$result = mysqli_query($conn, "SELECT * FROM view_keputusan_devitha");
?>

<table border="1">
    <tr>
        <th>Nama</th>
        <th>Hardware</th>
        <th>Jaringan</th>
        <th>Penggunaan</th>
        <th>Keputusan</th>
    </tr>
    <?php while ($d = mysqli_fetch_assoc($result)) : ?>
        <tr>
            <td><?= $d['nama']; ?></td>
            <td><?= $d['hardware']; ?></td>
            <td><?= $d['jaringan']; ?></td>
            <td><?= $d['penggunaan']; ?></td>
            <td><?= strtoupper($d['keputusan']); ?></td>
        </tr>
    <?php endwhile; ?>
</table>
