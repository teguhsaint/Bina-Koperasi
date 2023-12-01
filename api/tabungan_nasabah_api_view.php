
<?php
header('Access-Control-Allow-Origin: *');

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "db_koperasi";
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

$query = "SELECT * FROM tabungan_nasabah";
$res = mysqli_query($conn, $query);

$html = "";
$no = 1;
foreach ($res as $key) {
    $html .= "
<tr><td>" . $no++ . "</td>

<td>" . $key['kode_agt'] . "</td>
<td>" . $key['tanggal'] . "</td>
<td>" . $key['jumlah'] . "</td>
<td>" . $key['agt_nama'] . "</td>
<td><button onclick=\"button_muncul('".$key['id_tbg']."','". $key['kode_agt']."','". $key['tanggal']."','". $key['jumlah']."','" . $key['agt_nama'] ."')\" id='tombolOption' class='btn btn-sm btn-success' data-id=''><i class='fas fa-cog'></i></button></td>
</tr>";
}
echo $html;

?>

