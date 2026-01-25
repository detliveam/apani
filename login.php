<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include "koneksi.php";

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : "view";

/* DELETE */
if ($aksi == "hapus") {
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");
    header("Location: pelanggan.php");
    exit();
}

/* ADD */
if (isset($_POST['simpan'])) {
    mysqli_query($koneksi, "INSERT INTO pelanggan VALUES('', '$_POST[nama]','$_POST[alamat]','$_POST[jenis_kelamin]','$_POST[tlp]','$_POST[status_member]', NOW())");
    header("Location: pelanggan.php");
    exit();
}

/* UPDATE */
if (isset($_POST['update'])) {
    mysqli_query($koneksi, "UPDATE pelanggan SET 
        nama='$_POST[nama]', alamat='$_POST[alamat]',
        jenis_kelamin='$_POST[jenis_kelamin]', tlp='$_POST[tlp]',
        status_member='$_POST[status_member]'
        WHERE id_pelanggan='$_POST[id]' ");
    header("Location: pelanggan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pelanggan - Laundry App</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Poppins,sans-serif;}
.layout{display:flex;background:#f5f7fb;}

/* SIDEBAR */
.sidebar{
  width:250px;height:100vh;background:#ffffff;border-right:1px solid #e2e6ea;
  padding:25px;display:flex;flex-direction:column;position:fixed;left:0;top:0;
  animation:slideSidebar .4s ease-out;
}
.logo{font-size:22px;font-weight:700;margin-bottom:25px;}
.logo span{color:#1abc9c;}

.menu{list-style:none;margin-top:10px;}
.menu li{padding:12px 15px;border-radius:8px;margin-bottom:5px;transition:.25s;}
.menu li a{text-decoration:none;color:#555;font-size:15px;display:block;}
.menu li:hover,.menu li.active{background:#e9f9f3;font-weight:600;}

.logout{margin-top:auto;padding:10px;background:#ff4b4b;color:#fff;border:none;border-radius:8px;cursor:pointer;font-size:15px;}

/* CONTENT */
.content{width:100%;padding:30px;margin-left:250px;}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:30px;}
.topbar h2{font-size:26px;font-weight:700;}

.table{width:100%;border-collapse:collapse;background:#fff;border-radius:12px;overflow:hidden;margin-top:18px;}
.table th,.table td{padding:14px;border-bottom:1px solid #eee;font-size:15px;text-align:left;}
.table th{background:#fafafa;font-weight:600;}
.table tr:hover{background:#f5fbf8;}

.btn{padding:6px 14px;border:none;border-radius:6px;font-size:14px;cursor:pointer;color:white;}
.add-btn{background:#1abc9c;text-decoration:none;padding:10px 18px;border-radius:10px;color:white;font-size:15px;}
.edit{background:#3498db;}
.hapus{background:#e74c3c;}

/* FORM */
.form-box{
  width:450px;background:#fff;padding:25px;border-radius:12px;
  border:1px solid #e5e5e5;margin-top:10px;
}
input,select,textarea{
  width:100%;padding:12px;border:1px solid #ccc;border-radius:10px;font-size:15px;
  margin-bottom:12px;
}

/* ANIMASI SIDEBAR */
@keyframes slideSidebar{
  0%{opacity:0;transform:translateX(-30px);}
  100%{opacity:1;transform:translateX(0);}
}
</style>
</head>

<body>
<div class="layout">

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="logo">LAUNDRY <span>APP</span></div>

  <ul class="menu">
    <li><a href="dashboard.php">Dashboard</a></li>
    <li><a href="outlet.php">Outlet</a></li>
    <li><a href="paket.php">Paket</a></li>
    <li><a href="pengguna.php">Pengguna</a></li>
    <li class="active"><a href="pelanggan.php">Pelanggan</a></li>
    <li><a href="transaksi.php">Transaksi</a></li>
    <li><a href="laporan.php">Laporan</a></li>
  </ul>

  <form action="logout.php" method="POST"><button type="submit" class="logout">Logout</button></form>
</aside>

<!-- CONTENT -->
<main class="content">

<div class="topbar"><h2>Data Pelanggan</h2></div>

<?php if ($aksi == "view") { ?>
<a class="add-btn" href="pelanggan.php?aksi=tambah">+ Tambah Pelanggan</a>

<table class="table">
<thead>
 <tr><th>#</th><th>Nama</th><th>Alamat</th><th>JK</th><th>Telepon</th><th>Status</th><th>Aksi</th></tr>
</thead>
<tbody>
<?php
$no=1;$data=mysqli_query($koneksi,"SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
while($d=mysqli_fetch_array($data)){ ?>
<tr>
<td><?= $no++; ?></td>
<td><?= $d['nama']; ?></td>
<td><?= $d['alamat']; ?></td>
<td><?= $d['jenis_kelamin']; ?></td>
<td><?= $d['tlp']; ?></td>
<td><?= $d['status_member']; ?></td>
<td>
<button onclick="location.href='pelanggan.php?aksi=edit&id=<?= $d['id_pelanggan']; ?>'" class="btn edit">Edit</button>
<button onclick="if(confirm('Hapus pelanggan?')) location.href='pelanggan.php?aksi=hapus&id=<?= $d['id_pelanggan']; ?>'" class="btn hapus">Hapus</button>
</td>
</tr>
<?php } ?>
</tbody>
</table>

<?php } elseif ($aksi == "tambah") { ?>
<div class="form-box">
<h3>Tambah Pelanggan</h3><br>
<form method="POST">
<input type="text" name="nama" placeholder="Nama" required>
<textarea name="alamat" placeholder="Alamat" required></textarea>
<select name="jenis_kelamin"><option value="L">Laki-laki</option><option value="P">Perempuan</option></select>
<input type="text" name="tlp" placeholder="Telepon" required>
<select name="status_member"><option value="member">Member</option><option value="non_member">Non Member</option></select>
<button class="btn add-btn" type="submit" name="simpan">Simpan</button>
<button class="btn hapus" type="button" onclick="location.href='pelanggan.php'">Batal</button>
</form>
</div>

<?php } elseif ($aksi == "edit") {
$id=$_GET['id'];
$d=mysqli_fetch_array(mysqli_query($koneksi,"SELECT * FROM pelanggan WHERE id_pelanggan='$id'")); ?>
<div class="form-box">
<h3>Edit Pelanggan</h3><br>
<form method="POST">
<input type="hidden" name="id" value="<?= $d['id_pelanggan']; ?>">
<input type="text" name="nama" value="<?= $d['nama']; ?>">
<textarea name="alamat"><?= $d['alamat']; ?></textarea>
<select name="jenis_kelamin">
<option <?=($d['jenis_kelamin']=='L')?'selected':'';?> value="L">Laki-laki</option>
<option <?=($d['jenis_kelamin']=='P')?'selected':'';?> value="P">Perempuan</option>
</select>
<input type="text" name="tlp" value="<?= $d['tlp']; ?>">
<select name="status_member">
<option <?=($d['status_member']=='member')?'selected':'';?> value="member">Member</option>
<option <?=($d['status_member']=='non_member')?'selected':'';?> value="non_member">Non Member</option>
</select>
<button class="btn edit" type="submit" name="update">Update</button>
<button class="btn hapus" type="button" onclick="location.href='pelanggan.php'">Batal</button>
</form>
</div>
<?php } ?>

</main>
</div>
</body>
</html>
