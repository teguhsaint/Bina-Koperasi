<?php
\header('Access-Control-Allow-Origin: *');

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "db_koperasi";

$koneksi = mysqli_connect($db_host, $db_user, $db_password, $db_name);
$res= mysqli_query($koneksi,'SELECT * FROM nasabah  ');

$html ="";
$no=1;
foreach ($res as $key) {
    
    $html.= "
    <tr onclick='ambil_nasabah(this)' data_id='".$key['agt_kode']. "' data_nama='" . $key['agt_nama'] . "'>
    <td>".$no++."</td>
    <td>".$key['agt_nama']. "</td>
    <td>" . $key['agt_kode'] . "</td>
</tr>
    ";


}
echo $html;

?>
