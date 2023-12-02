<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


$kode = $_POST['kode'];
$tgl = $_POST['tanggal'];

$jml =  $_POST['jumlah'];
$id = $_POST['id'];
$nama = $_POST['nama'];


$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "db_koperasi";

$koneksi = mysqli_connect($db_host, $db_user, $db_password, $db_name);

$res = mysqli_query($koneksi, "update tabungan set jumlah='$jml',tanggal='$tgl', kode_agt='$kode' where id_tbg='$id'");
if ($res) {
    echo json_encode('berhasil');
}
