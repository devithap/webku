<?php
include 'koneksi.php';

// === TAMBAH PARAMETER ===
if (isset($_POST['add_parameter'])) {
    $no_res = $_POST['no_res'];
    $hardware = $_POST['hardware'];
    $jaringan = $_POST['jaringan'];
    $penggunaan = $_POST['penggunaan'];

    $sql = "INSERT INTO parameter_devitha (no_res, hardware, jaringan, penggunaan)
            VALUES ('$no_res', '$hardware', '$jaringan', '$penggunaan')";
    mysqli_query($conn, $sql);
    header("Location: parameter.php");
    exit;
}

// === UPDATE PARAMETER ===
if (isset($_POST['update_parameter'])) {
    $no_res = $_POST['no_res'];
    $hardware = $_POST['hardware'];
    $jaringan = $_POST['jaringan'];
    $penggunaan = $_POST['penggunaan'];

    $sql = "UPDATE parameter_devitha 
            SET hardware='$hardware', jaringan='$jaringan', penggunaan='$penggunaan'
            WHERE no_res='$no_res'";
    mysqli_query($conn, $sql);
    header("Location: parameter.php");
    exit;
}

// === HAPUS PARAMETER ===
if (isset($_GET['delete_parameter'])) {
    $no_res = $_GET['delete_parameter'];
    mysqli_query($conn, "DELETE FROM parameter_devitha WHERE no_res='$no_res'");
    header("Location: parameter.php");
    exit;
}

// === MODE EDIT ===
$edit_mode = false;
$no_res = $hardware = $jaringan = $penggunaan = "";

if (isset($_GET['edit_parameter'])) {
    $no_res   = $_GET['edit_parameter'];
    $res      = mysqli_query($conn, "SELECT * FROM parameter_devitha WHERE no_res='$no_res'");
    $row      = mysqli_fetch_assoc($res);
    $hardware = $row['hardware'];
    $jaringan = $row['jaringan'];
    $penggunaan = $row['penggunaan'];
    $edit_mode = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Penilaian Parameter</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background: url('sakura.GIF') no-repeat center center fixed;
        background-size: cover;
      }
      h2 { text-align:center; color:#003366; }
      form {
        width:400px; margin:20px auto;
        background:rgba(255,255,255,0.9);
        padding:20px; border-radius:10px;
        box-shadow:0 0 8px #888;
      }
      label { display:block; margin-top:10px; font-weight:bold; }
      select, input[type=number] {
        width:100%; padding:8px; box-sizing:border-box;
      }
      input[type=submit], input[type=reset], button {
        padding:8px 16px; margin-top:15px; margin-right:10px;
        background:#0066cc; color:#fff; border:none; border-radius:4px;
        cursor:pointer;
      }
      input[type=submit]:hover, button:hover { background:#004b99; }
      table {
        width:90%; margin:30px auto; border-collapse:collapse;
        background:rgba(255,255,255,0.9);
      }
      th, td { border:1px solid #666; padding:8px; text-align:center; }
      th { background:#003366; color:#fff; }
      a { color:#0066cc; text-decoration:none; }
      a:hover { text-decoration:underline; }
    </style>
</head>
<body>

<h2><?= $edit_mode ? "Edit Penilaian Parameter" : "Tambah Penilaian Parameter" ?></h2>

<form method="POST" action="parameter.php">
  <label>No Responden</label>
  <input type="number" name="no_res" required value="<?= $no_res ?>" <?= $edit_mode ? 'readonly' : '' ?>>

  <label>Penilaian Hardware</label>
  <select name="hardware" required>
    <option value="">-- Pilih --</option>
    <option value="Sangat Puas" <?= $hardware=='Sangat Puas'?'selected':'' ?>>Sangat Puas</option>
    <option value="Puas" <?= $hardware=='Puas'?'selected':'' ?>>Puas</option>
    <option value="Netral" <?= $hardware=='Netral'?'selected':'' ?>>Netral</option>
    <option value="Tidak Puas" <?= $hardware=='Tidak Puas'?'selected':'' ?>>Tidak Puas</option>
    <option value="Sangat Tidak Puas" <?= $hardware=='Sangat Tidak Puas'?'selected':'' ?>>Sangat Tidak Puas</option>
  </select>

  <label>Penilaian Jaringan</label>
  <select name="jaringan" required>
    <option value="">-- Pilih --</option>
    <option value="Sangat Puas" <?= $jaringan=='Sangat Puas'?'selected':'' ?>>Sangat Puas</option>
    <option value="Puas" <?= $jaringan=='Puas'?'selected':'' ?>>Puas</option>
    <option value="Netral" <?= $jaringan=='Netral'?'selected':'' ?>>Netral</option>
    <option value="Tidak Puas" <?= $jaringan=='Tidak Puas'?'selected':'' ?>>Tidak Puas</option>
    <option value="Sangat Tidak Puas" <?= $jaringan=='Sangat Tidak Puas'?'selected':'' ?>>Sangat Tidak Puas</option>
  </select>

  <label>Penggunaan</label>
  <select name="penggunaan" required>
    <option value="">-- Pilih --</option>
    <option value="Sangat Tinggi" <?= $penggunaan=='Sangat Tinggi'?'selected':'' ?>>Sangat Tinggi</option>
    <option value="Tinggi" <?= $penggunaan=='Tinggi'?'selected':'' ?>>Tinggi</option>
    <option value="Sedang" <?= $penggunaan=='Sedang'?'selected':'' ?>>Sedang</option>
    <option value="Rendah" <?= $penggunaan=='Rendah'?'selected':'' ?>>Rendah</option>
    <option value="Sangat Rendah" <?= $penggunaan=='Sangat Rendah'?'selected':'' ?>>Sangat Rendah</option>
  </select>

  <?php if($edit_mode): ?>
    <input type="submit" name="update_parameter" value="Update">
    <button type="button" onclick="window.location='parameter.php'">Batal</button>
  <?php else: ?>
    <input type="submit" name="add_parameter" value="Simpan">
    <input type="reset" value="Reset">
  <?php endif; ?>
</form>

<h2>Data Parameter</h2>
<table>
  <tr>
    <th>No</th>
    <th>No Res</th>
    <th>Hardware</th>
    <th>Jaringan</th>
    <th>Penggunaan</th>
    <th>Aksi</th>
  </tr>
  <?php
  $no = 1;
  $rs = mysqli_query($conn,"SELECT * FROM parameter_devitha");
  while($d = mysqli_fetch_assoc($rs)){
    echo "<tr>
            <td>$no</td>
            <td>{$d['no_res']}</td>
            <td>{$d['hardware']}</td>
            <td>{$d['jaringan']}</td>
            <td>{$d['penggunaan']}</td>
            <td>
              <a href='parameter.php?edit_parameter={$d['no_res']}'>Edit</a> |
              <a href='parameter.php?delete_parameter={$d['no_res']}' onclick=\"return confirm('Hapus data ini?')\">Hapus</a>
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
