<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$id_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : null;
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : null;
$jam_pelajaran = isset($_GET['jam_pelajaran']) ? $_GET['jam_pelajaran'] : null;

if ($id_kelas === null || $tanggal === null || $jam_pelajaran === null) {
    echo "Parameter tidak lengkap.";
    exit;
}

$query_delete = "DELETE FROM absensi WHERE id_kelas='$id_kelas' AND date_created='$tanggal' AND jam_pelajaran='$jam_pelajaran'";
$result_delete = mysqli_query($koneksi, $query_delete);

if ($result_delete) {
    echo "Absensi berhasil dihapus.";
} else {
    echo "Gagal menghapus absensi: " . mysqli_error($koneksi);
}

header("Location: rekapabsensi.php?kelas=$id_kelas");
exit;
?>