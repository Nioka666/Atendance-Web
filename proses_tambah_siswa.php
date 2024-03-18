<?php
include "./koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nis = mysqli_real_escape_string($koneksi, $_POST['nis']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jk = mysqli_real_escape_string($koneksi, $_POST['jk']);
    $tgl_lahir = mysqli_real_escape_string($koneksi, $_POST['tgl_lahir']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $id_kelas = mysqli_real_escape_string($koneksi, $_POST['id_kelas']);

    if (!strtotime($tgl_lahir)) {
        echo "Invalid date format for tgl_lahir";
        exit;
    }

    $insert_query = "INSERT INTO siswa (nis, nama, jk, tgl_lahir, alamat, id_kelas) 
                    VALUES ('$nis', '$nama', '$jk', '$tgl_lahir', '$alamat', '$id_kelas')";

    if (mysqli_query($koneksi, $insert_query)) {
        header("Location: lihatsiswa.php"); // Redirect to the daftar_siswa.php page
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
