<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');


$kode= $_POST['kode'];
$tgl= $_POST['tgl'];
$jml= str_replace(',','', $_POST['jml']);

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "db_koperasi";

$koneksi = mysqli_connect($db_host,$db_user,$db_password,$db_name);

$res=mysqli_query($koneksi, "INSERT INTO tabungan values(null,'$kode','$tgl','$jml')");

if(mysqli_affected_rows($koneksi)){
    echo json_encode('berhasil');
}

?>
