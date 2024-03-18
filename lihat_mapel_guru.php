<?php

session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

// if (isset($_session['id'])) {
//   echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
// }
$guru_id = $_SESSION['guru_id'];
$guru_name = $_SESSION["guru_user_name"];
$guru_foto = $_SESSION["guru_user_foto"];
$guru_last_login = $_SESSION["guru_user_last_login"];


$jumlah_mapel = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_guru='$guru_id'"));
$jumlah_kelas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_guru='$guru_id'"));
$jumlah_siswa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa"));

$result = mysqli_query($koneksi, "SELECT status FROM guru WHERE id_guru = '$guru_id'");
$row = mysqli_fetch_assoc($result);
$guru_status = $row["status"];

$guru_dash = "index.php";
$admin_dash = "admin.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Lihat Mata Pelajaran | SKANEDA</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- kustom sendiri -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body id="page-top">
    <div id="wrapper">
        <?php include "./sidebar.php" ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "./navbar.php" ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Lihat Mata Pelajaran </h1>
                    <div class="col-md-11">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex" style="gap: 499px">
                                <h5 class="m-0 font-weight-bold text-primary">Daftar Mata Pelajaran </h5>
                                <?php if ($guru_status === "admin") { ?>
                                    <button class="btn btn-primary text-white">
                                        <a href="tambah_mapel.php" class="text-white">Tambah Mapel</a>
                                    </button>
                                <?php } ?>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr align="center">
                                                <th>No</th>
                                                <th>Nama Mata Pelajaran</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody align="center">
                                            <?php
                                            $sql = "SELECT * FROM mapel WHERE id_guru = '$guru_id'";
                                            $query = mysqli_query($koneksi, $sql);
                                            $i = 1;
                                            while ($data = mysqli_fetch_array($query)) {
                                                $nama = $data["nama_mapel"];
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $i++; ?>
                                                    </td>
                                                    <td>
                                                        <?= $nama; ?>
                                                    </td>
                                                    <td>
                                                        <a href="proses_ubah_mapel.php?id_mapel=<?php echo $data['id_mapel']; ?>"
                                                            class="btn btn-warning btn-icon-split">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-pen"></i>
                                                            </span>
                                                            <span class="text">Ubah Mapel</span>
                                                        </a>
                                                        <a href="proses_hapus_mapel.php?id_mapel=<?php echo $data['id_mapel']; ?>"
                                                            class="btn btn-danger btn-icon-split"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus mapel ini?');">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                            <span class="text">Hapus Mapel</span>
                                                        </a>

                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include "./footer.php" ?>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <?php include "./logout_modal.php" ?>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>