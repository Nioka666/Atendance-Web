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
  <title>Rekap Absensi | SKANEDA </title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <style>
    .table-responsive {
      overflow-x: auto;
    }

    #dataTable thead tr {
      white-space: nowrap;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include "./sidebar.php" ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- Topbar -->
        <?php include "./navbar.php" ?>
        <div class="container-fluid">
          <?php
          $id_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : null;

          if ($id_kelas === null) {
            echo "Kelas tidak ditemukan.";
            exit;
          }

          $sql_kelas = "SELECT nama_kelas FROM kelas WHERE id_kelas='$id_kelas'";
          $result_kelas = mysqli_query($koneksi, $sql_kelas);
          $res_fetch = mysqli_fetch_assoc($result_kelas);
          $nama_kelas = $res_fetch['nama_kelas'];

          $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : null;
          $whereClause = '';

          if (!empty($tanggal)) {
            $tanggal = date("Y-m-d", strtotime($tanggal));
            $whereClause = " AND date_created='$tanggal'";
          }

          $sql = "SELECT DISTINCT date_created, jam_pelajaran FROM absensi WHERE id_kelas='$id_kelas' $whereClause ORDER BY date_created ASC";

          $result = mysqli_query($koneksi, $sql);

          if (!$result) {
            die("Query error: " . mysqli_error($koneksi));
          }

          ?>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <div class="kiri d-flex" style="gap: 410px;">
                <h3 class="m-0 font-weight-bold text-primary">Rekap Kehadiran Siswa
                  <?= $nama_kelas; ?>
                </h3>
                <a href="cetak_absensi.php?kelas=<?= $id_kelas; ?>&tanggal=<?= $tanggal; ?>"
                  class="btn btn-success mb-3" style="font-size: 18px; font-weight: 600;">Cetak Absensi</a>
              </div>
              <div class="filter-tanggal">
                <form action="" method="get" class="d-grid">
                  <label for="tanggal">Pilih Tanggal:</label>
                  <input class="form-control w-25" type="date" id="tanggal" name="tanggal" value="<?= $tanggal ?>"
                    required>
                  <input type="hidden" name="kelas" value="<?= $id_kelas; ?>">
                  <input type="submit" class="btn btn-primary mt-3" value="Apply Filter">
                </form>
              </div>
            </div>
            <div class="card-body">
              <?php
              if (mysqli_num_rows($result) > 0) {
                ?>
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th>No</th>
                        <th>Profil</th>
                        <th>NIS</th>
                        <th style="min-width: 150px;">Nama</th>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                          $tanggal = $row['date_created'];
                          $jam_pelajaran = $row['jam_pelajaran'];
                          echo "<th>" . $tanggal . " <br> ID Mapel: " . $jam_pelajaran;

                          // Tambahkan tombol HAPUS dengan konfirmasi onclick
                          echo "<br><a href='#' class='btn btn-danger btn-sm mt-2' onclick=\"confirmDelete('$id_kelas', '$tanggal', '$jam_pelajaran')\">HAPUS</a>";

                          echo "</th>";
                        }
                        ?>

                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <?php
                      $id_kelas = $_GET['kelas'];
                      $sql_siswa = "SELECT * FROM siswa WHERE id_kelas='$id_kelas'";
                      $query_siswa = mysqli_query($koneksi, $sql_siswa);
                      $i = 1;
                      while ($data_siswa = mysqli_fetch_array($query_siswa)) {
                        $nis_siswa = $data_siswa["nis"];
                        $nama_siswa = $data_siswa["nama"];
                        ?>
                        <tr>
                          <td>
                            <?= $i++; ?>
                          </td>
                          <td><i class="bi bi-person-circle mt-1" style="font-size: 32px;"></i></td>
                          <td>
                            <?= $nis_siswa; ?>
                          </td>
                          <td style="min-width: 150px;">
                            <?= $nama_siswa; ?>
                          </td>
                          <?php
                          $result_absensi_siswa = mysqli_query($koneksi, "SELECT * FROM absensi WHERE nis='$nis_siswa' AND id_kelas='$id_kelas'$whereClause");
                          while ($data_absensi_siswa = mysqli_fetch_array($result_absensi_siswa)) {
                            $keterangan = $data_absensi_siswa["keterangan"];
                            echo "<td>" . $keterangan . "</td>";
                          }
                          ?>
                          <td>
                            <a href="detaileditabsensi.php?kelas=<?= $id_kelas; ?>&nis=<?= $nis_siswa; ?>"
                              class="btn btn-warning btn-icon-split btn-sm">
                              <span class="icon text-white-50">
                                <i class="fas fa-edit"></i>
                              </span>
                              <span class="text">Ubah</span>
                            </a>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <?php
              } else {
                echo "<p>Tidak ada data yang ditemukan untuk tanggal ini.</p>";
              }
              ?>
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
  <?php include "./logout_modal.php"; ?>
  <script>
    function confirmDelete(id_kelas, tanggal, jam_pelajaran) {
      if (confirm('Apakah Anda yakin ingin menghapus absensi ini?')) {
        window.location.href = 'hapus_absensi.php?kelas=' + id_kelas + '&tanggal=' + tanggal + '&jam_pelajaran=' + jam_pelajaran;
      }
    }
  </script>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>