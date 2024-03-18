<?php
session_start();
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);
    $nama_kelas = mysqli_real_escape_string($koneksi, $_POST['nama_kelas']);
    $id_guru = mysqli_real_escape_string($koneksi, $_POST['id_guru']);

    $query = "UPDATE kelas SET nama_kelas = '$nama_kelas', id_guru = '$id_guru' WHERE id_kelas = '$id_kelas'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "<script>alert('Berhasil Mengubah data kelas'); window.location.href='lihatkelas.php';</script>";
        // header("Location: lihatkelas.php");
        exit;
    } else {
        echo "Error updating kelas: " . mysqli_error($koneksi);
    }
} else {
    echo "Invalid request";
}
?>