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


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id_kelas'])) {
    $id_kelas_to_edit = mysqli_real_escape_string($koneksi, $_GET['id_kelas']);

    $query = "SELECT * FROM kelas WHERE id_kelas = '$id_kelas_to_edit'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
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
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

                <!-- Custom styles for this template-->
                <link href="css/sb-admin-2.min.css" rel="stylesheet">
                <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

            </head>

            <body id="page-top">
                <div id="wrapper">
                    <?php include "./sidebar.php"; ?>
                    <div id="content-wrapper" class="d-flex flex-column">
                        <div id="content">
                            <?php include './navbar.php'; ?>
                            <div class="container-fluid">
                                <h1 class="mb-5 text-gray-800">Edit Kelas</h1>
                                <form method="POST" action="proses_edit_kelas.php">
                                    <input type="hidden" name="id_kelas" value="<?= $row['id_kelas']; ?>">
                                    <div class="form-group">
                                        <label for="nama_kelas">Nama Kelas:</label>
                                        <input type="text" class="form-control w-50" id="nama_kelas" name="nama_kelas"
                                            value="<?= $row['nama_kelas']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_guru">ID Guru:</label>
                                        <input type="text" class="form-control w-50" id="id_guru" name="id_guru"
                                            value="<?= $row['id_guru']; ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </form>
                            </div>
                        </div>
                        <?php include "./footer.php"; ?>
                    </div>
                </div>
                <!-- Include your necessary scripts here -->
            </body>

            </html>
            <?php
        } else {
            echo "Kelas not found.";
        }

        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "Invalid request";
}
?>