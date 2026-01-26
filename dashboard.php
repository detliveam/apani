<?php
include "koneksi.php";

/* ======================
   CREATE & UPDATE
====================== */
if (isset($_POST['simpan'])) {
    $nama  = $_POST['nama_pelanggan'];
    $paket = $_POST['paket'];
    $berat = $_POST['berat'];
    $id    = $_POST['id_transaksi'];

    if ($id == "") {
        // CREATE
        mysqli_query($conn, "INSERT INTO dashboard (nama_pelanggan, paket, berat)
                             VALUES ('$nama','$paket','$berat')");
    } else {
        // UPDATE
        mysqli_query($conn, "UPDATE dashboard 
                             SET nama_pelanggan='$nama',
                                 paket='$paket',
                                 berat='$berat'
                             WHERE id_transaksi='$id'");
    }
    header("location: dashboard.php");
    exit;
}

/* ======================
   DELETE
====================== */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM dashboard WHERE id_transaksi='$id'");
    header("location: dashboard.php");
    exit;
}

/* ======================
   EDIT (ambil data)
====================== */
$edit = false;
$id_transaksi = "";
$nama_pelanggan = "";
$paket = "";
$berat = "";

if (isset($_GET['edit'])) {
    $edit = true;
    $id_transaksi = $_GET['edit'];

    $data = mysqli_query(
        $conn,
        "SELECT * FROM dashboard WHERE id_transaksi='$id_transaksi'"
    );

    $d = mysqli_fetch_array($data);

    if ($d) {
        $nama_pelanggan = $d['nama_pelanggan'];
        $paket = $d['paket'];
        $berat = $d['berat'];
    } else {
        // kalau data tidak ditemukan
        header("location: dashboard.php");
        exit;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
   

   <style>
    {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}


body {
    display: flex;
    background: #f4f4f4;
}


.navbar {
    width: 220px;
    height: 100vh;
    background: #000;
    padding-top: 20px;
    position: fixed;
    left: 0;
    top: 0;
}

.navbar a {
    display: block;
    color: #fff;
    text-decoration: none;
    padding: 12px 20px;
}

.navbar a:hover {
    background: #333;
}
.navbar h2 {
    color: #fff;
}


.container {
    margin-left: 240px; 
    width: calc(100% - 240px);
    padding: 30px;
}


.container h2 {
    margin-bottom: 15px;
}


form {
    background: #fff;
    padding: 20px;
    width: 400px;
    margin: 0 auto 30px auto;
    border-radius: 5px;
}

form label {
    display: block;
    margin-top: 10px;
}

form input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
}

form button {
    margin-top: 15px;
    padding: 10px;
    width: 100%;
    background: #0ab9ff;
    color: #fff;
    border: none;
    cursor: pointer;
}

form button:hover {
    background: #333;
}


table {
    background: #fff;
    margin: 0 auto;
    width: 80%;
    border-collapse: collapse;
}

table th, table td {
    padding: 10px;
    text-align: center;
}

table th {
    background:  #0ab9ff;
    color: #fff;
}

table tr:nth-child(even) {
    background: #eee;
}


table a {
    color: #000;
    text-decoration: none;
    margin: 0 5px;
}
</style>
   

   
</head>
<body>

<h2>Welcome coy</h2>

<div class="navbar">
    <center><h2> Laundry </h2></center>
    <a href="dashboard.php">Dashboard</a>
    <a href="outlet.php">Outlet</a>
    <a href="paket.php">Paket</a>
    <a href="pengguna.php">Pengguna</a>
    <a href="pelanggan.php">Pelanggan</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="logout.php" onlick="return confirm('yakin logout?')">Logout</a>
</div>

<div class="container">
    <h2><?= $edit ? "Edit Transaksi" : "Input Data Laundry" ?></h2>

    <!-- FORM -->
    <form method="POST">
        <input type="hidden" name="id_transaksi" value="<?= $id_transaksi ?>">

        <label>Nama Pelanggan</label>
        <input type="text" name="nama_pelanggan" value="<?= $nama_pelanggan ?>" required>

        <label>Paket Laundry</label>
        <input type="text" name="paket" value="<?= $paket ?>" required>

        <label>Berat (KG)</label>
        <input type="number" name="berat" value="<?= $berat ?>" required>

        <button type="submit" name="simpan"><?= $edit ? "Update" : "Simpan" ?>
        </button>

        <?php if ($edit) { ?>
            <a href="dashboard.php">Batal</a>
        <?php } ?>
    </form>

    <h2>Data Transaksi</h2>

    <!-- TABLE -->
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Paket</th>
            <th>Berat</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        $data = mysqli_query($conn,"SELECT * FROM dashboard");
        while ($d = mysqli_fetch_array($data)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $d['nama_pelanggan'] ?></td>
            <td><?= $d['paket'] ?></td>
            <td><?= $d['berat'] ?> KG</td>
            <td>
                <a href="dashboard.php?edit=<?= $d['id_transaksi'] ?>">Edit</a> 
                <a href="dashboard.php?hapus=<?= $d['id_transaksi'] ?>" onclick="return confirm('Yakin hapus data?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
