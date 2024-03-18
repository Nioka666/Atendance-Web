<?php
include "koneksi.php";
session_start();

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


// Query untuk mendapatkan status guru dari database
$result = mysqli_query($koneksi, "SELECT status FROM guru WHERE id_guru = '$guru_id'");
$row = mysqli_fetch_assoc($result);
$guru_status = $row["status"];

$guru_dash = "index.php";
$admin_dash = "admin.php";

// Pengecekan status
if ($guru_status == "guru") {
    echo "<script>alert('Maaf, Status anda bukan admin!');  window.location.href='index.php';</script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tambah Kelas | SKANEDA</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include "./sidebar.php"; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include './navbar.php'; ?>
                <div class="container-fluid">
                    <h1 class="mb-5 text-gray-800">Tambah Kelas</h1>

                    <!-- Tambah Kelas Form -->
                    <form method="POST" action="proses_tambah_kelas.php">
                        <div class="form-group">
                            <label for="nama_kelas">Nama Kelas:</label>
                            <input type="text" class="form-control w-50" id="nama_kelas" name="nama_kelas" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah Kelas</button>
                    </form>
                    <!-- End Tambah Kelas Form -->
                </div>
            </div>
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Yakin ingin keluar?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Pilih Logout untuk keluar</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>