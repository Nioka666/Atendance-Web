<?php
session_start();
// detail_edit_guru.php

include "koneksi.php"; // Assuming this file contains your database connection details
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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_guru'])) {

    $id_guru_to_edit = mysqli_real_escape_string($koneksi, $_GET['id_guru']);

    // Fetch the guru data from the database based on the provided 'id_guru'
    $query = "SELECT * FROM guru WHERE id_guru = '$id_guru_to_edit'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Check if there is a guru with the provided 'id_guru'
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Render the form for editing guru data
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="utf-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                <title>Edit Guru | SKANEDA</title>
                <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
                <link
                    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
                    rel="stylesheet">
                <link href="css/sb-admin-2.min.css" rel="stylesheet">
            </head>

            <body id="page-top">
                <div id="wrapper">
                    <?php include "./sidebar.php"; ?>
                    <div id="content-wrapper" class="d-flex flex-column">
                        <div id="content">
                            <?php include './navbar.php'; ?>
                            <div class="container-fluid">
                                <h1 class="mb-5 text-gray-800">Edit Guru</h1>

                                <!-- Edit Guru Form -->
                                <form method="POST" action="proses_edit_guru.php">
                                    <!-- Hidden input for passing 'id_guru' to the processing script -->
                                    <input type="hidden" name="id_guru" value="<?= $row['id_guru']; ?>">

                                    <div class="form-group">
                                        <label for="nama">Nama:</label>
                                        <input type="text" class="form-control w-50" id="nama" name="nama"
                                            value="<?= $row['nama']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_hp">No Telfon:</label>
                                        <input type="text" class="form-control w-50" id="no_hp" name="no_hp"
                                            value="<?= $row['no_hp']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status:</label>
                                        <select class="form-control w-50" id="status" name="status" required>
                                            <option value="admin" <?= ($row['status'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                            <option value="guru" <?= ($row['status'] == 'guru') ? 'selected' : ''; ?>>Guru</option>
                                        </select>
                                    </div>


                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                                <!-- End Edit Guru Form -->
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
            <?php
        } else {
            echo "Guru not found.";
        }

        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Invalid request";
}
?>