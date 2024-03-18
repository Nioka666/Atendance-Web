<?php

session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";
/*
    if(isset($_session['id'])){
        echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';	
    }*/
$guru_id = $_SESSION['guru_id'];
$guru_name = $_SESSION["guru_user_name"];
$guru_foto = $_SESSION["guru_user_foto"];
$guru_last_login = $_SESSION["guru_user_last_login"];

$result = mysqli_query($koneksi, "SELECT status FROM guru WHERE id_guru = '$guru_id'");
$row = mysqli_fetch_assoc($result);
$guru_status = $row["status"];

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
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Guru | SKANEDA</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="wrapper">
        <?php include "./sidebar.php"; ?>
        <!-- content section -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include './navbar.php'; ?>

                <!-- Content Section -->
                <div class="container-fluid">
                    <h1 class="mb-5 text-gray-800">Guru Page</h1>

                    <!-- Daftar Guru Section -->
                    <div class="row">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex" style="gap: 700px">
                                <h5 class="m-0 font-weight-bold text-primary">Daftar Guru</h5>
                                <button class="btn btn-primary text-white">
                                    <a href="tambah_guru.php" class="text-white">Tambah Guru</a>
                                </button>
                            </div>
                            <div class="card-body">
                                <!-- Tabel Guru Section -->
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <!-- Tabel Header Section -->
                                        <thead>
                                            <tr align="center">
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>No Telfon</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <!-- Tabel Body Section -->
                                        <tbody align="center">
                                            <?php
                                            // Query to fetch data from the guru table
                                            $query = "SELECT * FROM guru";
                                            $result = mysqli_query($koneksi, $query);

                                            // Check if the query was successful
                                            if ($result):
                                                $no = 1; // Counter for the row number
                                            
                                                // Fetch each row from the result set
                                                while ($row = mysqli_fetch_assoc($result)):
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $no++; ?>
                                                        </td>
                                                        <td>
                                                            <?= $row['nama']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $row['no_hp']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $row['status']; ?>
                                                        </td>
                                                        <td>
                                                            <a href='detail_edit_guru.php?id_guru=<?= $row['id_guru']; ?>'
                                                                class='btn btn-warning btn-icon-split btn-sm'>
                                                                <span class='icon text-white-50'><i
                                                                        class='fas fa-edit'></i></span>
                                                                <span class='text'>Ubah</span>
                                                            </a>

                                                            <a style='margin-left:15px;'
                                                                href='hapus_guru.php?id_guru=<?= $row['id_guru']; ?>'
                                                                class='btn btn-danger btn-icon-split btn-sm'
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus guru ini?');">
                                                                <span class='icon text-white-50'><i
                                                                        class='fas fa-edit'></i></span>
                                                                <span class='text'>Hapus</span>
                                                            </a>
                                                        </td>

                                                    </tr>
                                                    <?php
                                                endwhile;
                                            else:
                                                // Handle the case when the query fails
                                                echo "Error: " . mysqli_error($koneksi);
                                            endif;

                                            // Close the result set
                                            mysqli_free_result($result);
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Content Section -->
            </div>
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Logout Modal-->
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
            <?php include "./footer.php" ?>
        </div>
    </div>



    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>