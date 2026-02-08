<?php
include "koneksi.php";
include "header.php";

    if(isset($_POST['simpan'])) {
        $nama = $_POST['nama'];
        $tanggal = $_POST['tanggal'];
        $prioritas = $_POST['prioritas'];
        $status = $_POST['status'];

        if($_POST['id'] == ""){
        mysqli_query($conn,"INSERT INTO todolist (nama,tanggal,prioritas,status) VALUES ('$nama','$tanggal','$prioritas','$status')");

      } else {
        $id = $_POST['id'];
            mysqli_query($conn,"UPDATE todolist SET nama='$nama',tanggal='$tanggal',prioritas='$prioritas',status='$status' WHERE id='$id'");
        }
        header("location: coba.php");
        exit;
    }

        if(isset($_GET['hapus'])) {
            $id = $_GET['hapus'];
            mysqli_query($conn,"DELETE FROM todolist WHERE id='$id'");
            header("location: coba.php");
            exit;
        }
        $edit = false;
        $nama = "";
        $tanggal = "";
        $prioritas = "";
        $status = "";
        $id = "";

        if (isset($_GET['edit'])) {
            $edit = true;
            $id = $_GET['edit'];
            $data = mysqli_query($conn,"SELECT * FROM todolist WHERE id='$id'");
            $d = mysqli_fetch_array($data);
            
            if($d) {
                $nama = $d['nama'];
                $tanggal = $d['tanggal'];
                $prioritas = $d['prioritas'];
                $status = $d['status'];

            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>latian</title>
      <style>
            body {
               
                background: #f4f4f4;
            }   
           
            .container {
                margin-left: 240px;
                margin-top: 120px;
                width: calc(100% - 240px);
                padding: 30px;
            }
            .container h2 {
                margin-bottom: 20px;
                text-align: center;
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

            table th,
            table td {
                padding: 10px;
                text-align: center;
            }

            table th {
                background: #0ab9ff;
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
            .prioritas.tinggi {
                color: white;
                background: #e74c3c;
                font-weight: bold;
            }

            .prioritas.sedang {
                color: black;
                background: #f1c40f;
                font-weight: bold;
            }

            .prioritas.rendah {
                color: white;
                background: #2ecc71;
                font-weight: bold;
            }
        </style>
</head>
<body>
    
        
    <div class ="container">
        <h2><?= $edit ? "Edit Tugas" : "Input Tugas"; ?></h2>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">

            <label>Nama Tugas </label>
            <input type="text" name="nama" value="<?=  $nama ?>" required>

            <label>Tanggal Tugas</label>
            <input type="date" name="tanggal" value="<?= $tanggal?>"reuuired>

       <label>Prioritas</label>
       <select name="prioritas" required>
        <option value="">Pilih Prioritas</option>
        <option value="tinggi" <?= $prioritas == "tinggi" ? "selected" : "" ?>>Tinggi </option>
        <option value="sedang" <?=  $prioritas == "sedang" ? "selected" : "" ?>>Sedang</option>
        <option value="rendah" <?= $prioritas == "rendah" ? "selected" : "" ?>>Rendah</option>
       </select>

       <label>Status</label>
       <select name="status" required>
        <option value="">Pilih Status </option>
        <option value="belum" <?= $status == "belum" ? "selected" : "" ?>>Belum</option>
         <option value="selesai" <?= $status == "selesai" ? "selected" : "" ?>>Selesai</option>
       </select>
       <button type="submit" name="simpan"><?= $edit ? "Update" : "Simpan"; ?></button>

       <?php if ($edit) { ?>
       <a href="latian.php">Batal</a>
        <?php } ?>
    </form>

        <h2>Data Tugas</h2>
        <table border="1">
            <tr>
                <th>No</th>
                <th>Nama Tugas</th>
                <th>Tanggal Tugas</th>
                <th>Prioritas Tugas</th>
                <th>Status Tugas</th>
                <th>Aksi</th>
            </tr>

            <?php 
            $no = 1;
            $data = mysqli_query($conn,"SELECT * FROM todolist");
            while ($d = mysqli_fetch_array($data)) {
            ?>

                <tr>
                    <td><?= $no++ ?> </td>
                    <td><?= $d['nama'] ?></td>
                    <td><?= $d['tanggal'] ?></td>
                    <td class="prioritas <?=  $d['prioritas'] ?>"><?= ucfirst($d['prioritas']) ?></td>
                    <td><?= $d['status'] ?></td>
                    <td>
                        <a href="coba.php?edit=<?= $d['id'] ?>">Edit</a>
                        <a href="coba.php?hapus=<?= $d['id'] ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
               <?php } ?>

            </table>
    </div>
</body>
</html>
