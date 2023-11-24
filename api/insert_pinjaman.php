<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


$kode_pj = $_POST['kode_pj'];
$kode_Anggota = $_POST['kode_Anggota'];
$tanggal = $_POST['tanggal'];
$jumlah = str_replace(',', '', $_POST['jumlah']);
$bunga = $_POST['bunga'];
$status = $_POST['status'];

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "db_koperasi";

$koneksi = mysqli_connect($db_host, $db_user, $db_password, $db_name);

$res = mysqli_query($koneksi, "INSERT INTO pinjaman values(null,'$kode_pj','$kode_Anggota','$tanggal','$jumlah','$bunga','$status')");

if (mysqli_affected_rows($koneksi)) {
    echo json_encode('berhasil');
}
