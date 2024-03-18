<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_guru'])) {
    $id_guru_to_delete = mysqli_real_escape_string($koneksi, $_GET['id_guru']);
    $delete_query = "DELETE FROM guru WHERE id_guru = '$id_guru_to_delete'";

    if (mysqli_query($koneksi, $delete_query)) {
        echo "<script>alert('Berhasil menghapus data guru'); window.location.href='guru.php'</script>";
        // header("Location: guru.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Invalid request";
}
