<?php
header('Access-Control-Allow-Origin: *');

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "db_koperasi";

$koneksi = mysqli_connect($db_host, $db_user, $db_password, $db_name);
$res = mysqli_query($koneksi, 'SELECT * FROM nasabah JOIN pinjaman On nasabah.agt_kode = pinjaman.kode_anggota');

$html = "";
$no = 1;
foreach ($res as $key) {

    $html .= "
    <tr onclick='ambil_data_pinjaman(this)' data_nama='" . $key['agt_nama'] . "' data_id='" . $key['agt_kode'] . "'>
    <td>" . $no++ . "</td>
    <td>" . $key['tanggal'] . "</td>
    <td>" . $key['kode_pj'] . "</td>
    <td>" . $key['agt_nama'] . "</td>
    <td>Rp." . number_format($key['jumlah'],0) . "</td>
</tr>
    ";
}
echo $html;
