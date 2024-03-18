<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}
include "koneksi.php";
$guru_id = $_SESSION['guru_id'];
$guru_name = $_SESSION["guru_user_name"];
$guru_last_login = $_SESSION["guru_user_last_login"];

$tgl = date("d-m-Y");
$jumlah_guru = mysqli_num_rows(mysqli_query($koneksi, "select * from guru where status='guru'"));
$jumlah_kelas = mysqli_num_rows(mysqli_query($koneksi, "select * from kelas"));
$jumlah_siswa = mysqli_num_rows(mysqli_query($koneksi, "select * from siswa"));

$result = mysqli_query($koneksi, "SELECT status FROM guru WHERE id_guru = '$guru_id'");
$row = mysqli_fetch_assoc($result);
$guru_status = $row["status"];

// Ambil data kelas untuk looping
$query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
$kelas_options = '';
while ($data_kelas = mysqli_fetch_array($query_kelas)) {
  $kelas_id = $data_kelas['id_kelas'];
  $kelas_nama = $data_kelas['nama_kelas'];
  $kelas_options .= "<option value=\"$kelas_id\">$kelas_nama</option>";
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

  <title>Lihat siswa | SKANEDA</title>

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
  <div id="wrapper">
    <?php include './sidebar.php'; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php include "./navbar.php"; ?>
        <div class="container-fluid">
          <h1 class="h3 mb-4 text-gray-800">Lihat siswa</h1>

          <!-- Formulir untuk filter kelas -->
          <form method="get" action="">
            <div class="form-group d-flex" style="gap: 20px;">
              <label for="filter_kelas">Filter Kelas:</label>
              <select class="form-control" id="filter_kelas" name="filter_kelas" style="width: 150px">
                <option value="">Semua Kelas</option>
                <?php
                $query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
                while ($data_kelas = mysqli_fetch_assoc($query_kelas)) {
                  $selected = ($data_kelas['id_kelas'] == $_GET['filter_kelas']) ? 'selected' : '';
                  echo "<option value='" . $data_kelas['id_kelas'] . "' $selected>" . $data_kelas['nama_kelas'] . "</option>";
                }
                ?>
              </select>
              <button type="submit" class="btn btn-primary">Apply Filter</button>
            </div>
          </form>
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex" style="gap: 700px">
              <h5 class="m-0 font-weight-bold text-primary">Daftar Siswa</h5>
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
                      <th>Profil</th>
                      <th>nis</th>
                      <th>Nama</th>
                      <th>Kelas</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody align="center">
                    <?php
                    $filter_kelas = isset($_GET['filter_kelas']) ? $_GET['filter_kelas'] : '';
                    $filter_sql = $filter_kelas ? " WHERE id_kelas = '$filter_kelas'" : "";

                    $sql = "SELECT * FROM siswa" . $filter_sql;
                    $query = mysqli_query($koneksi, $sql);
                    $i = 1;

                    while ($data = mysqli_fetch_array($query)) {
                      $nis = $data["nis"];
                      $nama = $data["nama"];
                      $kelas = $data["id_kelas"];
                    ?>
                      <tr>
                        <td><?= $i++; ?></td>
                        <td>
                          <i class="bi bi-person-circle mt-1" style="font-size: 32px;"></i>
                        </td>
                        <td><?= $nis; ?></td>
                        <td><?= $nama; ?></td>
                        <td>
                          <?php
                          $kelas_id = $data["id_kelas"];
                          $query_kelas_by_id = mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas = '$kelas_id'");
                          $data_kelas = mysqli_fetch_assoc($query_kelas_by_id);

                          if ($data_kelas) {
                            echo $data_kelas['nama_kelas'];
                          } else {
                            echo 'Kelas tidak ditemukan';
                          }
                          ?>
                        </td>

                        <td>
                          <a href="ubah_siswa.php?nis=<?php echo $nis; ?>" class="btn btn-warning btn-icon-split">
                            <span class="icon text-white-50">
                              <i class="fas fa-pen"></i>
                            </span>
                          </a>
                          <a href="hapus_siswa.php?nis=<?php echo $nis; ?>" class="btn btn-danger btn-icon-split" onclick="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                            <span class="icon text-white-50">
                              <i class="fas fa-trash"></i>
                            </span>
                            <span class="text">Hapus</span>
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
      <?php include "./footer.php"; ?>
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