<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_kelas = isset($_GET['id']) ? $_GET['id'] : null;
    $date_created = isset($_GET['date_created']) ? $_GET['date_created'] : null;
    $jam_pelajaran = isset($_GET['jam_pelajaran']) ? $_GET['jam_pelajaran'] : null;
    $guru_id = $_SESSION['guru_id'];

    $resultAbsensiHariIni = mysqli_query($koneksi, "SELECT * FROM absensi WHERE id_kelas='$id_kelas' AND date_created='$date_created' AND id_guru='$guru_id'");

    if (mysqli_num_rows($resultAbsensiHariIni) > 0) {
        $msg = "Anda sudah melakukan absensi pada tanggal $date_created untuk kelas $id_kelas.";
        echo "<script>alert('$msg'); window.location.href='absensi.php';</script>";
        exit;
    }

    $siswa_query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$id_kelas'");
    while ($siswa_data = mysqli_fetch_array($siswa_query)) {
        $nis = $siswa_data["nis"];
        $keterangan = isset($_POST['ket' . $nis]) ? $_POST['ket' . $nis] : null;

        $sql = "INSERT INTO absensi (jam_pelajaran, keterangan, id_kelas, nis, date_created, id_guru) 
            VALUES ('$jam_pelajaran', '$keterangan', '$id_kelas', '$nis', '$date_created', '$guru_id')";

        $result = mysqli_query($koneksi, $sql);

        if (!$result) {
            echo "Error: " . mysqli_error($koneksi);
            echo "Query: " . $sql;
            exit;
        }
    }

    $msg = "Anda Berhasil melakukan absensi pada $jam_pelajaran, tanggal $date_created untuk kelas $id_kelas.";
    echo "<script>alert('$msg'); window.location.href='absensi.php';</script>";
    exit;
} else {
    header("Location: index.php");
    exit;
}
