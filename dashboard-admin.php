<?php
include 'koneksi.php';

?>


<!DOCTYPE html>
<html lang="id">
<head>
<title>Dashboard Laundry Aby</title>

<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600,700" rel="stylesheet">

<style>

*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:'Poppins',sans-serif;
}

.layout{
  display:flex;
  min-height:100vh;
  background:#f5f6fa;
}

.sidebar {
      width: 240px;
      background-color: #007bff;
      color: #fff;
      display: flex;
      flex-direction: column;
      padding: 20px;
    }

.logo{
  text-align:center;
  margin-bottom:25px;
}

.menu{
  list-style:none;
}

.menu li a{
  display:block;
  padding:12px;
  color:white;
  text-decoration:none;
  border-radius:8px;
  margin-bottom:8px;
  transition:.3s;
}

.menu li a:hover{
  background:rgba(255,255,255,.25);
}

.menu li a.active{
  background:rgba(255,255,255,.35);
}

.main-area{
  flex:1;
  display:flex;
  flex-direction:column;
}

.navbar {
      background-color: #eaf2ff;
      padding: 15px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 2px solid #007bff;
    }

    .navbar h1 {
      color: #007bff;
      font-size: 1.3rem;
      font-weight: 700;
    }
.user-area{
  display:flex;
  align-items:center;
  gap:10px;
}

.logout-btn{
  text-decoration:none;
  border:1px solid #007bff;
  color:#007bff;
  padding:6px 12px;
  border-radius:8px;
  transition:.3s;
}

.logout-btn:hover{
  background:#007bff;
  color:white;
}

.content{
  padding:20px 25px;
}

.box-wrapper{
  display:flex;
  gap:15px;
  margin-bottom:20px;
}

.info-box{
  flex:1;
  background:white;
  border-radius:12px;
  padding:15px;
  box-shadow:0 0 10px rgba(0,0,0,.1);
  display:flex;
  align-items:center;
  gap:15px;
}

.icon{
  width:60px;
  height:60px;
  border-radius:10px;
  display:flex;
  align-items:center;
  justify-content:center;
  color:white;
  font-size:26px;
}

.icon.outlet{background:#0fbcf9;}
.icon.pelanggan{background:#05c46b;}
.icon.transaksi{background:#ffa801;}

.text-area h3{
  color:#7f8fa6;
  font-size:.95rem;
}

.table-container{
  background:white;
  padding:15px;
  border-radius:12px;
  box-shadow:0 0 10px rgba(0,0,0,.1);
  margin-top:15px;
}

table{
  width:100%;
  border-collapse:collapse;
}

th,td{
  padding:10px;
  border-bottom:1px solid #dcdde1;
  text-align:center;
}

th{
  background:#0fbcf9;
  color:white;
}

.btn{
  padding:8px 12px;
  border:none;
  border-radius:8px;
  cursor:pointer;
  color:white;
  transition:.3s;
}

.btn.tambah{background:#0fbcf9;}
.btn.edit{background:#05c46b;}
.btn.hapus{background:#ff3f34;}

.popup{
  position:fixed;
  top:0;
  left:0;
  width:100%;
  height:100vh;
  background:rgba(0,0,0,.4);
  display:none;
  align-items:center;
  justify-content:center;
}

.popup-box{
  width:420px;
  background:white;
  padding:20px;
  border-radius:12px;
  box-shadow:0 0 15px rgba(0,0,0,.2);
  animation:muncul .3s ease;
}

@keyframes muncul{
  from{transform:scale(0);}
  to{transform:scale(1);}
}

.input-decoration{
  padding:12px;
  background:#f1f2f6;
  border-radius:10px;
  margin-bottom:10px;
}

.popup-box input{
  width:100%;
  padding:10px;
  margin-bottom:10px;
  border-radius:8px;
  border:1px solid #b2bec3;
}

</style>
</head>

<body>

<div class="layout">

<div class="sidebar">
    <div class="logo">
      <h2>Laundry Bersih</h2>
    </div>

    <ul class="menu">
      <li><a href="dashboard-admin.php" class="active">🏠 Dashboard</a></li>
      <li><a href="outlet.php">📦 Outlet</a></li>
      <li><a href="paket.php">💰 Paket</a></li>
      <li><a href="pengguna.php">👥 Pengguna</a></li>
      <li><a href="pelanggan.php">👥 Pelanggan</a></li>
      <li><a href="transaksi.php">⚙️ Transaksi</a></li>
    </ul>
  </div>

  <div class="main-area">

    <div class="navbar">
      <h1>Dashboard </h1>

      <div class="user-area">
        <span>Admin</span>
        <a href="logout.php" class="logout-btn">Logout</a>
      </div>
    </div>

    <div class="content">

      <h2>Dashboard Utama</h2>

      <div class="box-wrapper">

        <div class="info-box">
          <div class="icon outlet">📦</div>
          <div class="text-area">
            <h3>Outlet</h3>
            <h1 id="totalOutlet">0</h1>
          </div>
        </div>

        <div class="info-box">
          <div class="icon pelanggan">👥</div>
          <div class="text-area">
            <h3>Total Pelanggan</h3>
            <h1 id="totalPelanggan">0</h1>
          </div>
        </div>

        <div class="info-box">
          <div class="icon transaksi">💰</div>
          <div class="text-area">
            <h3>Total Transaksi</h3>
            <h1 id="totalTransaksi">0</h1>
          </div>
        </div>

      </div>

      <button class="btn tambah" onclick="showPopup()">Tambah Transaksi</button>

      <div class="table-container">
        <h3>Riwayat Transaksi</h3>

        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Pelanggan</th>
              <th>Tanggal</th>
              <th>Total</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody id="trxTable"></tbody>
        </table>
      </div>

    </div>

  </div>

</div>

<div class="popup" id="popupForm">
  <div class="popup-box">
    <h2>Input Transaksi Baru</h2>

    <div class="input-decoration">
      <input type="hidden" id="trxId">
      <input id="pelanggan" placeholder="Nama Pelanggan">
      <input id="tanggal" type="date">
      <input id="total" placeholder="Total Harga">
    </div>

    <button class="btn tambah" onclick="saveTrx()">Simpan</button>
    <button class="btn hapus" onclick="hidePopup()">Batal</button>
  </div>
</div>

<script>

let pelanggan = JSON.parse(localStorage.getItem("pelanggan")) || [];
let transactions = JSON.parse(localStorage.getItem("transactions")) || [];

function renderTotalBoxes(){

  // Total Outlet dari halaman ini jika ada
  let outlets = JSON.parse(localStorage.getItem("outlets")) || [];
  document.getElementById("totalOutlet").innerText = outlets.length;

  // Total pelanggan dari menu pelanggan
  document.getElementById("totalPelanggan").innerText = pelanggan.length;

  // Total transaksi
  document.getElementById("totalTransaksi").innerText = transactions.length;
}

function renderTable(){
  const table = document.getElementById("trxTable");
  table.innerHTML = "";

  transactions.forEach(trx=>{
    table.innerHTML += `
      <tr>
        <td>${trx.id}</td>
        <td>${trx.pelanggan}</td>
        <td>${trx.tanggal}</td>
        <td>${trx.total}</td>
        <td>
          <button class="btn edit" onclick="editTrx(${trx.id})">Edit</button>
          <button class="btn hapus" onclick="deleteTrx(${trx.id})">Hapus</button>
        </td>
      </tr>
    `;
  });

  renderTotalBoxes();
}

function showPopup(){
  document.getElementById("popupForm").style.display="flex";
  clearForm();
}

function hidePopup(){
  document.getElementById("popupForm").style.display="none";
}

function clearForm(){
  document.getElementById("trxId").value="";
  document.getElementById("pelanggan").value="";
  document.getElementById("tanggal").value="";
  document.getElementById("total").value="";
}

function saveTrx(){

  const pelangganInput = document.getElementById("pelanggan").value;
  const tanggalInput = document.getElementById("tanggal").value;
  const totalInput = document.getElementById("total").value;

  if(pelangganInput==""||tanggalInput==""||totalInput==""){
    alert("Isi semua data");
    return;
  }

  const newId = transactions.length
    ? transactions[transactions.length-1].id + 1
    : 1;

  transactions.push({
    id:newId,
    pelanggan:pelangganInput,
    tanggal:tanggalInput,
    total:totalInput
  });

  localStorage.setItem("transactions", JSON.stringify(transactions));

  hidePopup();
  renderTable();
}

function editTrx(id){
  const trx = transactions.find(t=>t.id==id);

  // Buka popup TANPA mengubah data
  document.getElementById("popupForm").style.display="flex";
  document.getElementById("trxId").value = trx.id;
  document.getElementById("pelanggan").value = trx.pelanggan;
  document.getElementById("tanggal").value = trx.tanggal;
  document.getElementById("total").value = trx.total;
}

function updateTrx(){

  const id = document.getElementById("trxId").value;
  const pelangganBaru = document.getElementById("pelanggan").value;
  const tanggalBaru = document.getElementById("tanggal").value;
  const totalBaru = document.getElementById("total").value;

  const index = transactions.findIndex(t=>t.id == id);

  transactions[index] = {
    id: parseInt(id),
    pelanggan: pelangganBaru,
    tanggal: tanggalBaru,
    total: totalBaru
  };

  localStorage.setItem("transactions", JSON.stringify(transactions));

  hidePopup();
  renderTable();
}

function deleteTrx(id){
  transactions = transactions.filter(t=>t.id!=id);
  localStorage.setItem("transactions", JSON.stringify(transactions));
  renderTable();
}

// Render awal
renderTable();
renderTotalBoxes();

</script>

</body>
</html