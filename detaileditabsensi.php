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

$jumlah_mapel = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM mapel"));
$jumlah_kelas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas "));
$jumlah_siswa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa"));

// Query untuk mendapatkan status guru dari database
$result = mysqli_query($koneksi, "SELECT status FROM guru WHERE id_guru = '$guru_id'");
$row = mysqli_fetch_assoc($result);
$guru_status = $row["status"];

$id_kelas = $_GET['kelas'];
$nis = $_GET['nis'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Edit Absensi | SKANEDA</title>

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
  <div id="wrapper">
    <?php include "./sidebar.php"; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "./navbar.php"; ?>
        <div class="container-fluid">
          <h1 class="h3 mb-4 text-gray-800">Ubah Absensi </h1>
          <form role="form" action="editabsensi.php?kelas=<?php echo $id_kelas; ?>&nis=<?php echo $nis; ?>" method="post" name="postform" enctype="multipart/form-data">
            <?php
            $sql = "SELECT *, k.nama_kelas FROM siswa s JOIN kelas k ON s.id_kelas=k.id_kelas WHERE nis='$nis'";
            $query = mysqli_query($koneksi, $sql);

            if (!$query) {
              // Query execution failed
              echo "Error: " . mysqli_error($koneksi);
            } else {
              while ($data = mysqli_fetch_array($query)) {
                $nama = $data["nama"];
                $nama_kelas = $data["nama_kelas"];
              }
            }
            ?>


            <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Detail Siswa</h6>
                </div>
                <div class="card-body">
                  <form role="form" action=".php?id=<?php echo $_GET['kelas']; ?>" method="post" name="postform" enctype="multipart/form-data">
                    <div class="table-responsive">
                      <table class="table table-bordered" id="" width="100%" cellspacing="0">
                        <thead>
                          <tr align="center">
                            <th>nis</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                          </tr>
                        </thead>
                        <tbody align="center">
                          <th><?= $nis; ?></th>
                          <th><?= $nama; ?></th>
                          <th><?= $nama_kelas; ?></th>
                        </tbody>
                      </table>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Detail Absensi</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="" width="100%" cellspacing="0">
                      <thead>
                        <tr align="center">
                          <th>Tanggal</th>
                          <th>Keterangan</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <?php
                        $sql = "SELECT * FROM `absensi` WHERE id_kelas='$id_kelas' AND nis='$nis'";
                        $query = mysqli_query($koneksi, $sql);

                        while ($data = mysqli_fetch_array($query)) {
                          $id_absen = $data[0];
                          $tanggal = $data["date_created"];
                          $keterangan = $data["keterangan"];
                        ?>
                          <tr>
                            <td><?= $tanggal; ?></td>
                            <td>
                              <label class="radio-inline"><input type="radio" name="<?= 'ket' . $id_absen; ?>" id="<?= 'opsi1' . $id_absen; ?>" <?php if ($keterangan == "Hadir") {
                                                                                                                                                  echo "checked";
                                                                                                                                                } ?> value="Hadir">Hadir</label>
                              <label class="radio-inline"><input type="radio" name="<?= 'ket' . $id_absen; ?>" id="<?= 'opsi1' . $id_absen; ?>" <?php if ($keterangan == "Absen") {
                                                                                                                                                  echo "checked";
                                                                                                                                                } ?> value="Absen">Absen</label>
                              <label class="radio-inline"><input type="radio" name="<?= 'ket' . $id_absen; ?>" id="<?= 'opsi1' . $id_absen; ?>" <?php if ($keterangan == "Sakit") {
                                                                                                                                                  echo "checked";
                                                                                                                                                } ?> value="Sakit">Sakit</label>
                              <label class="radio-inline"><input type="radio" name="<?= 'ket' . $id_absen; ?>" id="<?= 'opsi1' . $id_absen; ?>" <?php if ($keterangan == "Izin") {
                                                                                                                                                  echo "checked";
                                                                                                                                                } ?> value="Izin">Izin</label>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
  <?php include "./footer.php"; ?>
  </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <?php include "./logout_modal.php" ?>

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