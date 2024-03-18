<?php
session_start();
include "./koneksi.php";

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
    <title>Tambah Siswa | SKANEDA</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include './sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include "./navbar.php"; ?>
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Tambah Siswa</h1>
                    
                    <form action="proses_tambah_siswa.php" method="post">
                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS:</label>
                            <input type="text" name="nis" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama:</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="jk" class="form-label">Jenis Kelamin:</label>
                            <select name="jk" class="form-select" required>
                                <option value="Pria">Pria</option>
                                <option value="Wanita">Wanita</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir:</label>
                            <input type="date" name="tgl_lahir" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat:</label>
                            <textarea name="alamat" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="id_kelas" class="form-label">Kelas:</label>
                            <select name="id_kelas" class="form-select" required>
                                <?php
                                $query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
                                while ($data_kelas = mysqli_fetch_assoc($query_kelas)) {
                                    $selected = ($data_siswa['id_kelas'] == $data_kelas['id_kelas']) ? 'selected' : '';
                                    echo "<option value='" . $data_kelas['id_kelas'] . "' $selected>" . $data_kelas['nama_kelas'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Tambah Siswa</button>
                        </div>
                    </form>
                </div>
            </div>
            <?php include "./footer.php"; ?>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>