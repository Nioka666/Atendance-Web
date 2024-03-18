<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nis = $_POST["nis"];
    $nama = $_POST["nama"];
    $jk = $_POST["jk"];
    $tgl_lahir = $_POST["tgl_lahir"];
    $alamat = $_POST["alamat"];
    $id_kelas = $_POST["id_kelas"];

    $query = "UPDATE siswa
            SET nama = '$nama', jk = '$jk', tgl_lahir = '$tgl_lahir', alamat = '$alamat', id_kelas = '$id_kelas'
            WHERE nis = '$nis'";

    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // header("Location: lihatsiswa.php");
        echo "<script>alert('Berhasil mengubah data siswa'); window.location.href='lihatsiswa.php';</script>";
        exit;
    } else {
        echo "Gagal mengubah data siswa. Silakan coba lagi.";
    }
} else {
    header("Location: lihatsiswa.php");
    exit;
}
