<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');



// Lakukan konfigurasi koneksi database
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "db_koperasi";

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Proses parameter dari DataTables
$draw = $_POST['draw'];
$start = $_POST['start'];
$length = $_POST['length'];
$search = $_POST['search']['value'];
$order = $_POST['order'][0];

// Define the columns for sorting
$columns = [
    'no', 'agt_kode', 'agt_tglmasuk', 'agt_nik', 'agt_nama', 'agt_alamat', 'agt_nohp', 'option'
];

// Validate and sanitize the order column
$orderColumn = in_array($order['column'], range(0, count($columns) - 1)) ? $columns[$order['column']] : 'no';

// Construct the SQL query with sorting and searching
$query = "SELECT * FROM nasabah WHERE agt_nama LIKE '%$search%' OR agt_kode LIKE '%$search%' OR agt_alamat LIKE '%$search%' OR agt_nik LIKE '%$search%' OR agt_tglmasuk LIKE '%$search%' ORDER BY $orderColumn {$order['dir']} LIMIT $start, $length";
$result = $conn->query($query);

// Hitung total data (tanpa filter)
$totalData = $conn->query("SELECT COUNT(*) as total FROM nasabah")->fetch_assoc()['total'];

// Hitung data yang sesuai dengan filter pencarian
$totalFiltered = $conn->query("SELECT COUNT(*) as total FROM nasabah WHERE agt_nama LIKE '%$search%' OR agt_kode LIKE '%$search%' OR agt_alamat LIKE '%$search%' OR agt_nik LIKE '%$search%' OR agt_tglmasuk LIKE '%$search%'")->fetch_assoc()['total'];

// Bangun respons JSON untuk DataTables
$data = array();
$no = 0;
while ($row = $result->fetch_assoc()) {
    $formattedDate = date('j M y', strtotime($row['agt_tglmasuk']));

    $no++;
    $id = $row['agt_id'];
    $data[] = array($no, $row['agt_kode'], $row['agt_tglmasuk'],  $row['agt_nik'], $row['agt_nama'], $row['agt_alamat'], $row['agt_nohp'],  "<button onclick='ambil_tabel(this)' class='btn btn-sm btn-success' dataid='" . $id . "'><i class='fas fa-cog'></i></button>");
}

// Send the response
$response = array(
    "draw" => intval($draw),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
);

echo json_encode($response);
