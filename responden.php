<?php
include 'koneksi.php';

// === TAMBAH RESPONDEN ===
if (isset($_POST['add_responden'])) {
    $no_res = $_POST['no_res'];
    $nama = $_POST['nama'];
    $jenkel = $_POST['jenkel'];
    $kelas = $_POST['kelas'];

   $sql = "INSERT INTO responden_devitha (no_res, nama, jenkel, kelas) VALUES ('$no_res', '$nama', '$jenkel', '$kelas')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data responden berhasil ditambahkan'); window.location.href='responden.php';</script>";
    } else {
        echo "Gagal tambah: " . mysqli_error($conn);
    }
}


// === UPDATE RESPONDEN ===
if (isset($_POST['update_responden'])) {
    $no_res = $_POST['no_res'];
    $nama = $_POST['nama'];
    $jenkel = $_POST['jenkel'];
    $kelas = $_POST['kelas'];

    $sql = "UPDATE responden_devitha SET nama='$nama', jenkel='$jenkel', kelas='$kelas' WHERE no_res='$no_res'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data responden berhasil diupdate'); window.location.href='responden.php';</script>";
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}

// === HAPUS RESPONDEN ===
if (isset($_GET['delete_responden'])) {
    $no_res = $_GET['delete_responden'];
    $sql = "DELETE FROM responden_devitha WHERE no_res='$no_res'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Data responden berhasil dihapus'); window.location.href='responden.php';</script>";
    } else {
        echo "Gagal hapus: " . mysqli_error($conn);
    }
}

// === MODE EDIT ===
$edit_mode = false;
$no_res = $nama = $jenkel = $kelas = "";

if (isset($_GET['edit_responden'])) {
    $no_res = $_GET['edit_responden'];
    $data = mysqli_query($conn, "SELECT * FROM responden_devitha WHERE no_res='$no_res'");
    if ($row = mysqli_fetch_assoc($data)) {
        $nama = $row['nama'];
        $jenkel = $row['jenkel'];
        $kelas = $row['kelas'];
        $edit_mode = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Responden</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-image: url('semi.GIF');
    background-size: cover;
}
        h2 {
            text-align: center;
            color: #003366;
        }
        form {
            width: 400px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 8px #aaa;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type=text], input[type=number], select {
            width: 100%;
            padding: 6px;
            box-sizing: border-box;
        }
        input[type=submit], input[type=reset], button {
            padding: 6px 16px;
            margin-top: 15px;
            margin-right: 10px;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type=submit]:hover, button:hover {
            background-color: #004b99;
        }
        table {
            margin: 30px auto;
            border-collapse: collapse;
            width: 90%;
            background-color: white;
        }
        table, th, td {
            border: 1px solid #999;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        a {
            text-decoration: none;
            color: #0066cc;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2><?= $edit_mode ? "Edit Data Responden" : "Tambah Data Responden" ?></h2>

<form method="POST" action="responden.php">
    <label>No Responden</label>
    <input type="number" name="no_res" value="<?= $no_res ?>" <?= $edit_mode ? 'readonly' : 'required' ?>>

    <label>Nama</label>
    <input type="text" name="nama" value="<?= $nama ?>" required>

    <label>Jenis Kelamin</label>
    <select name="jenkel" required>
        <option value="">-- Pilih --</option>
        <option value="L" <?= ($jenkel == 'L') ? 'selected' : '' ?>>Laki-laki</option>
        <option value="P" <?= ($jenkel == 'P') ? 'selected' : '' ?>>Perempuan</option>
    </select>

    <label>Kelas</label>
    <input type="text" name="kelas" value="<?= $kelas ?>" required>

    <?php if ($edit_mode): ?>
        <input type="submit" name="update_responden" value="Update">
        <button type="button" onclick="window.location.href='responden.php'">Batal</button>
    <?php else: ?>
        <input type="submit" name="add_responden" value="Simpan">
        <input type="reset" value="Reset">
    <?php endif; ?>
</form>

<h2>Daftar Responden</h2>

<table>
    <tr>
        <th>No</th>
        <th>No Res</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Kelas</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    $data = mysqli_query($conn, "SELECT * FROM responden_devitha");
    while ($d = mysqli_fetch_assoc($data)) {
        echo "<tr>
                <td>$no</td>
                <td>{$d['no_res']}</td>
                <td>{$d['nama']}</td>
                <td>{$d['jenkel']}</td>
                <td>{$d['kelas']}</td>
                <td>
                    <a href='responden.php?edit_responden={$d['no_res']}'>Edit</a> |
                    <a href='responden.php?delete_responden={$d['no_res']}' onclick=\"return confirm('Yakin mau hapus?')\">Hapus</a>
                </td>
              </tr>";
        $no++;
    }
    ?>
</table>

<audio autoplay loop hidden>
  <source src="laguku.mp3" type="audio/mpeg">
</audio>

</body>
</html>



