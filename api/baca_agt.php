<?php
header('Access-Control-Allow-Origin: *');

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "db_koperasi";

$koneksi = mysqli_connect($db_host, $db_user, $db_password, $db_name);
$res= mysqli_query($koneksi, 'SELECT * FROM nasabah WHERE NOT EXISTS ( SELECT 1 FROM pinjaman WHERE nasabah.agt_kode = pinjaman.kode_anggota AND pinjaman.status = 1 ) ORDER BY agt_kode ASC;  ');

$html ="";
$no=1;
foreach ($res as $key) {
    
    $html.= "
    <tr onclick='ambil_data_pinjaman(this)' data_id='".$key['agt_kode']. "' data_nama='" . $key['agt_nama'] . "'>
    <td>".$no++."</td>
    <td>" . $key['agt_kode'] . "</td>
    <td>".$key['agt_nama']. "</td>
</tr>
    ";


}
echo $html;

?>
