<?php
include "koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_kelas'])) {
    $id_kelas = mysqli_real_escape_string($koneksi, $_GET['id_kelas']);

    $check_query = "SELECT COUNT(*) as total FROM kelas WHERE id_kelas = '$id_kelas'";
    $check_result = mysqli_query($koneksi, $check_query);
    $check_data = mysqli_fetch_assoc($check_result);

    if ($check_data['total'] > 0) {
        $delete_query = "DELETE FROM kelas WHERE id_kelas = '$id_kelas'";

        if (mysqli_query($koneksi, $delete_query)) {
            echo "<script>alert('Berhasil menghapus kelas');</script>";
            echo "<script>window.location.href = 'lihatkelas.php';</script>";
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        echo "<script>alert('Kelas tidak ditemukan.');</script>";
        echo "<script>window.location.href = 'lihatkelas.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request');</script>";
    echo "<script>window.location.href = 'lihatkelas.php';</script>";
}
