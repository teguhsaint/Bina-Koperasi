<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_pj = $_POST['kode_pj'];
    $kode_anggota = $_POST['kode_anggota'];
    $tanggal = $_POST['tanggal'];
    $jumlah = $_POST['jumlah'];
    $bunga = $_POST['bunga'];
    $status = $_POST['status'];}
    try {
        $query = "INSERT INTO pinjaman (kode_pj, kode_anggota, tanggal, jumlah, bunga, status) 
                VALUES (:kode_pj, :kode_anggota, :tanggal, :jumlah, :bunga, :status)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':kode_pj', $kode_pj);
        $stmt->bindParam(':kode_anggota', $kode_anggota);
        $stmt->bindParam(':tanggal', $tanggal);
        $stmt->bindParam(':jumlah', $jumlah);
        $stmt->bindParam(':bunga', $bunga);
        $stmt->bindParam(':status', $status);

        $stmt->execute();


        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>