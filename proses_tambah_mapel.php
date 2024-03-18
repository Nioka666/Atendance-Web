<?php
include "koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_mapel = mysqli_real_escape_string($koneksi, $_POST['nama_mapel']);
    $jenis_mapel = mysqli_real_escape_string($koneksi, $_POST['jenis_mapel']);


    $guru_id = $_SESSION['guru_id'];

    $check_query = "SELECT COUNT(*) as total FROM mapel WHERE nama_mapel = '$nama_mapel'";
    $check_result = mysqli_query($koneksi, $check_query);
    $check_data = mysqli_fetch_assoc($check_result);

    if ($check_data['total'] > 0) {
        echo "<script>alert('Nama mapel sudah ada. Silakan pilih nama mapel lain.'); window.location.href='tambah_mapel.php';</script>";
    } else {
        $insert_query = "INSERT INTO mapel (nama_mapel, jenis_mapel, id_guru) VALUES ('$nama_mapel', '$jenis_mapel', '$guru_id')";

        if (mysqli_query($koneksi, $insert_query)) {
            echo "<script>alert('Berhasil menambahkan data mapel');</script>";
            header("Location: lihatmapel.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
} else {
    echo "Invalid request";
}
