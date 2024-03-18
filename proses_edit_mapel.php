<?php
session_start();
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_mapel = mysqli_real_escape_string($koneksi, $_POST['id_mapel']);
    $nama_mapel = mysqli_real_escape_string($koneksi, $_POST['nama_mapel']);
    $jenis_mapel = mysqli_real_escape_string($koneksi, $_POST['jenis_mapel']);
    $id_guru = mysqli_real_escape_string($koneksi, $_POST['id_guru']);

    $query = "UPDATE mapel SET nama_mapel = '$nama_mapel', jenis_mapel = '$jenis_mapel', id_guru = '$id_guru' WHERE id_mapel = '$id_mapel'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Berhasil Mengubah data mapel'); window.location.href='lihatmapel.php';</script>";
        // header("Location: lihatmapel.php");
        exit;
    } else {
        echo "Error updating mapel: " . mysqli_error($koneksi);
    }
} else {
    echo "Invalid request";
}
?>