<?php
header('Access-Control-Allow-Origin: *');
include 'model.php';

$hasil = select_data_custom('SELECT * FROM nasabah ORDER BY agt_id DESC LIMIT 5');
$html = '';

while ($nasa = mysqli_fetch_assoc($hasil)) {
    $html .= "
<li class='timeline-item'>
<strong><a href='javascript:void(0)' class='text-decoration-none text-body'>" . $nasa['agt_nama'] . "</a></strong>
<span class='float-end text-success text-sm'>";
    $html .= "" . $nasa['agt_tglmasuk'] . "";
    $html .= "</span>
<p class='text-muted'>" .  $nasa['agt_alamat']. "</p>
</li>
";
}

echo $html;
