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

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Absensi | SKANEDA</title>

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
        <?php include './navbar.php'; ?>
        <div class="container-fluid">

          <h1 class="mb-5 text-gray-800">Absensi</h1>
          <div class="row">
            <div class="col-md-6 animated--fade-in">
              <div class="card shadow mb-4">
                <?php if ($guru_status !== 'admin') { ?>
                  <a href="#absen" class="d-block card-header py-3" data-toggle="collapse" role="button"
                    aria-expanded="true" aria-controls="absen">
                    <h6 class="m-0 font-weight-bold text-primary">Menu Pengisian Absensi</h6>
                  </a>
                <?php } ?>
                <div class="collapse hide" id="absen">
                  <div class="card-body">
                    <form role="form" action="detailabsensi.php" method="POST" name="postform"
                      enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select id="kelas" class="form-control" name="kelas" required>
                          <?php
                          $sql_kelas = mysqli_query($koneksi, "select * from kelas where id_guru = $guru_id");
                          while ($data = mysqli_fetch_array($sql_kelas)) {
                            echo "<option value='{$data['id_kelas']}'>{$data['nama_kelas']}</option>";
                          }
                          ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="date_created">Tanggal</label>
                        <input type="date" id="date_created" name="date_created" required>
                      </div>

                      <div class="form-group">
                        <label for="jam_pelajaran">Mata Pelajaran ke</label>
                        <select id="jam_pelajaran" class="form-control" name="jam_pelajaran" required>
                          <?php
                          $sql_mapel = mysqli_query($koneksi, "SELECT * FROM mapel WHERE id_guru = $guru_id");
                          while ($data_mapel = mysqli_fetch_array($sql_mapel)) {
                            $selected = ($data_mapel['id_mapel'] == $jam_pelajaran) ? 'selected' : '';
                            echo "<option value='{$data_mapel['id_mapel']}' $selected>{$data_mapel['nama_mapel']}</option>";
                          }
                          ?>
                        </select>
                      </div>

                      <button type="submit" class="btn btn-primary">Absen Sekarang!</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#rekap" class="d-block card-header py-3" data-toggle="collapse" role="button"
                  aria-expanded="true" aria-controls="rekap">
                  <h6 class="m-0 font-weight-bold text-primary">Menu Rekap Absensi</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse hide" id="rekap">
                  <div class="card-body">
                    <form role="form" action="rekapabsensi.php" method="get" name="postform"
                      enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select id="kelas" class="form-control" name="kelas">
                          <?php
                          $sql_kelas = mysqli_query($koneksi, "select * from kelas");
                          while ($data = mysqli_fetch_array($sql_kelas)) {
                            echo "<option value='$data[0]' > $data[1] </option>";
                          }

                          ?>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary">Pilih Kelas</button>
                    </form>
                  </div>
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
  <?php include "./logout_modal.php"; ?>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/sb-admin-2.min.js"></script>
</body>

</html>