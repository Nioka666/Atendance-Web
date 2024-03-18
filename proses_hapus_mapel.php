<?php
include "koneksi.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_mapel'])) {
    $id_mapel = mysqli_real_escape_string($koneksi, $_GET['id_mapel']);

    $check_query = "SELECT COUNT(*) as total FROM mapel WHERE id_mapel = '$id_mapel'";
    $check_result = mysqli_query($koneksi, $check_query);
    $check_data = mysqli_fetch_assoc($check_result);

    if ($check_data['total'] > 0) {
        $delete_query = "DELETE FROM mapel WHERE id_mapel = '$id_mapel'";

        if (mysqli_query($koneksi, $delete_query)) {
            echo "<script>alert('Berhasil menghapus mapel');</script>";
            echo "<script>window.location.href = 'lihatmapel.php';</script>"; // Redirect to the desired page after deletion
        } else {
            // Deletion failed
            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        echo "<script>alert('mapel tidak ditemukan.');</script>";
        echo "<script>window.location.href = 'lihatmapel.php';</script>"; // Redirect to the desired page after error
    }
} else {
    echo "<script>alert('Invalid request');</script>";
    echo "<script>window.location.href = 'lihatmapel.php';</script>";
}
