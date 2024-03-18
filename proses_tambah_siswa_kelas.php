<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$guru_id = $_SESSION['guru_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis_siswa = $_POST['nis_siswa'];
    $id_kelas = $_POST['id_kelas'];
    $id_kelas_sekarang = $_GET['id_kelas_sekarang'];

    $query_cek_siswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nis = '$nis_siswa' AND id_kelas = '$id_kelas'");
    $jumlah_cek_siswa = mysqli_num_rows($query_cek_siswa);

    if ($jumlah_cek_siswa > 0) {
        echo "Siswa sudah ada di kelas tersebut";
    } else {
        $query_tambah_siswa = mysqli_query($koneksi, "UPDATE siswa SET id_kelas = '$id_kelas_sekarang' WHERE nis = '$nis_siswa'");

        if ($query_tambah_siswa) {
            header("Location: detail_kelas.php?id_kelas=<?= $id_kelas_sekarang?>");
            exit;
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
} else {
    header("Location: lihatkelas.php");
    exit;
}
