<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

include "koneksi.php";

$guru_id = $_SESSION['guru_id'];
$guru_name = $_SESSION["guru_user_name"];
$guru_foto = $_SESSION["guru_user_foto"];
$guru_last_login = $_SESSION["guru_user_last_login"];

$result = mysqli_query($koneksi, "SELECT status FROM guru WHERE id_guru = '$guru_id'");
$row = mysqli_fetch_assoc($result);
$guru_status = $row["status"];

if (isset($_GET['id_kelas'])) {
    $id_kelas = $_GET['id_kelas'];
    $query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas = '$id_kelas'");
    $data_kelas = mysqli_fetch_assoc($query_kelas);
    $nama_kelas = $data_kelas['nama_kelas'];

    $query_murid = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas = '$id_kelas'");
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Lihat Kelas | Detail Kelas</title>

        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    </head>

    <body id="page-top">
        <div id="wrapper">
            <?php include "./sidebar.php"; ?>
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include "./navbar.php" ?>

                    <div class="container-fluid">
                        <h1 class="h3 mb-4 text-gray-800">Detail Kelas:
                            <?= $nama_kelas; ?>
                        </h1>

                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex" style="gap: 670px">
                                <h6 class="m-0 font-weight-bold text-primary">Daftar Murid</h6>
                                <button class="btn btn-primary text-white">
                                    <a href="tambah_siswa.php" class="text-white">Tambah Data</a>
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr align="center">
                                                <th>No</th>
                                                <th>NIS</th>
                                                <th>Nama Murid</th>
                                                <th>Aksi</th>
                                                <!-- Add more columns if needed -->
                                            </tr>
                                        </thead>
                                        <tbody align="center">
                                            <?php
                                            $i = 1;
                                            while ($data_murid = mysqli_fetch_array($query_murid)) {
                                                $nis = $data_murid["nis"];
                                                $nama_murid = $data_murid["nama"];
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $i++; ?>
                                                    </td>
                                                    <td>
                                                        <?= $nis; ?>
                                                    </td>
                                                    <td>
                                                        <?= $nama_murid; ?>
                                                    </td>
                                                    <td>
                                                        <a href="ubah_siswa.php?nis=<?php echo $nis; ?>"
                                                            class="btn btn-warning btn-icon-split">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-pen"></i>
                                                            </span>
                                                            <span class="text">Ubah data</span>
                                                        </a>
                                                        <a href="hapus_siswa.php?nis=<?php echo $nis; ?>"
                                                            class="btn btn-danger btn-icon-split"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                            <span class="text">Hapus</span>
                                                        </a>
                                                    </td>
                                                    <!-- Add more columns if needed -->
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include "./footer.php"; ?>
            </div>
        </div>

        <!-- ... (remaining part of the page remains the same) ... -->

    </body>

    </html>
    <?php
} else {
    // Redirect if id_kelas parameter is not provided
    header("Location: lihatkelas.php");
    exit;
}
?>