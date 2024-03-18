<?php
include "koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kelas = mysqli_real_escape_string($koneksi, $_POST['nama_kelas']);
    $guru_id = $_SESSION['guru_id'];

    $check_query = "SELECT COUNT(*) as total FROM kelas WHERE nama_kelas = '$nama_kelas'";
    $check_result = mysqli_query($koneksi, $check_query);
    $check_data = mysqli_fetch_assoc($check_result);

    if ($check_data['total'] > 0) {
        echo "<script>alert('Nama kelas sudah ada. Silakan pilih nama kelas lain.'); window.location.href='tambah_kelas.php';</script>";
    } else {
        $insert_query = "INSERT INTO kelas (nama_kelas, id_guru) VALUES ('$nama_kelas', '$guru_id')";

        if (mysqli_query($koneksi, $insert_query)) {
            echo "<script>alert('Berhasil menambahkan data kelas');</script>";
            header("Location: lihatkelas.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
} else {
    echo "Invalid request";
}
