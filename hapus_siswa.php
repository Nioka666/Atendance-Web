<?php
session_start();
include "koneksi.php";

$nis = $_GET['nis'];

if (empty($nis)) {
    echo "Invalid NIS";
    exit;
}

$query_hapus = mysqli_query($koneksi, "DELETE FROM siswa WHERE nis = '$nis'");

if ($query_hapus) {
    echo "Siswa berhasil dihapus.";
} else {
    echo "Error: " . mysqli_error($koneksi);
}

header("Location: lihatsiswa.php");
echo "<script>alert('siswa berhasil dihapus')</script>";
exit;
