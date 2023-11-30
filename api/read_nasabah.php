<!-- datatabel -->
<?php
header("Content-Type: application/json");
header('Access-Control-Allow-Origin: *');
require_once 'connect.php';
$sql = "select count(*) as total from nasabah";
$result = $db->query($sql);
$row = $result->fetch_assoc();
$totalrecords = $row['total'];


$limit = $_GET['length'];
$start = $_GET['start'];
$orderColumnIndex = $_GET['order'][0]['column'];
$orderDir = $_GET['order'][0]['dir'];

$columns = ['agt_id','agt_kode','agt_nama','agt_nik','agt_alamat','agt_nohp',
'agt_ktp','tanggal_register'];
$orderBy = $columns[$orderColumnIndex];

$sql = "select * from nasabah join ao on substing_index(nasabah.agt_kode,'_',1) = ao.kode_ao";

$searchValue = $_GET['search']['value'];

if (!empty($searchValue)) {
    
    $sql .= " WHERE agt_nama LIKE '%$searchValue%'
     OR agt_nik LIKE '%$searchValue%' 
     or agt_alamat like '%$searchValue%' 
    or agt_nohp like '%$searchValue%'";
}

$sql .= " order by $orderBy $orderDir limit $start, $limit";
$result = $db->query($sql);
$totalrecordsFiltered =$result->num_rows;

$no = 1;

$data = array();
while ($row = $result->fetch_assoc()) {
    $row['index']=$no++;
    $tombol = [
        'tombol'=> '
        <a
          href=""
          id="edit"
          data-id="' . $row['agt_id'] . '"
          class="btn btn-flat btn-warning"
          data-bs-toggle="modal"
          data-bs-target="#staticBackdrop"
          >edit</a>
        <a href="" id="hapus" data-id="' . $row['agt_id'] . '" class="btn btn-danger"
          >hapus</a>
      '
    ];
    $data[]=$row;
};

$output = [
    "draw"=>intval($_GET['draw']),
    'recordsTotal'=>$totalrecords,
    'recordsFiltered'=>$totalrecordsFiltered,
    'data'=>$data
];


echo json_encode($output);
