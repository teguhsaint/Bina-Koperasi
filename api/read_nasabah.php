<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
require_once 'connect.php';

$sql = "SELECT count(*) as total FROM nasabah";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$totalrecords = $row['total'];

$limit = $_GET['length'];
$start = $_GET['start'];
$orderColumnIndex = $_GET['order'][0]['column'];
$orderDir = $_GET['order'][0]['dir'];

$columns = ['agt_id','agt_kode','agt_nama','agt_nik','agt_alamat','agt_nohp','agt_ktp','tanggal_register'];
$orderBy = $columns[$orderColumnIndex];

$sql = "SELECT * FROM nasabah";

$searchValue = $_GET['search']['value'];

if (!empty($searchValue)) {
    $sql .= " WHERE agt_nama LIKE '%$searchValue%'
             OR agt_nik LIKE '%$searchValue%' 
             OR agt_alamat LIKE '%$searchValue%' 
             OR agt_nohp LIKE '%$searchValue%'
             OR agt_kode LIKE '%$searchValue%'";
}

$sql .= " ORDER BY $orderBy $orderDir LIMIT $start, $limit";
$result = $db->query($sql);
$totalrecordsFiltered = $result->num_rows;

$no = 1;

$data = array();
while ($row = $result->fetch_assoc()) {
    $row['index'] = $no++;
    $ktp =$row['agt_ktp'];
    $id = $row['agt_id'];
    $tombol = [
        'tombol'=> '
        
        <button id="opt" data-id="' . $id. '" class="btn btn-danger"
          >Opt</button>
      ',
      'image'=>'<img src="uploads/'.$ktp.'" alt="" id="gambar" style="td img {  border-radius:2px!important }">'
      
      
    ];
    $data[] = $row + $tombol;
}

$output = [
    "draw" => intval($_GET['draw']),
    'recordsTotal' => $totalrecords,
    'recordsFiltered' => $totalrecordsFiltered,
    'data' => $data
];

echo json_encode($output);
