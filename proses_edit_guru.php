<?php

include "koneksi.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_guru'])) {
    $id_guru = mysqli_real_escape_string($koneksi, $_POST['id_guru']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $status = mysqli_real_escape_string($koneksi, $_POST['status']);

    $update_query = "UPDATE guru SET nama = '$nama', no_hp = '$no_hp', status = '$status' WHERE id_guru = '$id_guru'";

    if (mysqli_query($koneksi, $update_query)) {
        echo "<script>alert('Berhasil Mengubah data guru'); window.location.href='guru.php';</script>";
        // header("Location: guru.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Invalid request";
}
?>