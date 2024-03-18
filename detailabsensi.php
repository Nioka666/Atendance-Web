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
$id_kelas = isset($_POST['kelas']) ? $_POST['kelas'] : null;
$date_created = isset($_POST['date_created']) ? $_POST['date_created'] : null;
$jam_pelajaran = isset($_POST['jam_pelajaran']) ? $_POST['jam_pelajaran'] : null;

$jumlah_guru = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM guru WHERE status='Guru'"));
$jumlah_kelas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kelas"));
$jumlah_siswa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa"));

$result = mysqli_query($koneksi, "SELECT status FROM guru WHERE id_guru = '$guru_id'");
if ($result) {
  $row = mysqli_fetch_assoc($result);
  $guru_status = $row["status"];
} else {
  // Handle error, misalnya dengan menampilkan pesan atau melakukan redirect
  echo "Error: " . mysqli_error($koneksi);
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

  <title>Absensi | SKANEDA</title>

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <?php include "./sidebar.php"; ?>
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <?php
        $sql_kelass = "SELECT nama_kelas FROM kelas WHERE id_kelas='$id_kelas'";
        $result_kelas = mysqli_query($koneksi, $sql_kelass);
        $res_fetch = mysqli_fetch_assoc($result_kelas);
        $nama_kelas = $res_fetch['nama_kelas'];

        ?>
        <?php include "./navbar.php"; ?>
        <div class="container-fluid">
          <?php
          $id_kelas = isset($_POST['kelas']) ? $_POST['kelas'] : null;
          $date_created = isset($_POST['date_created']) ? $_POST['date_created'] : null;
          $jam_pelajaran = isset($_POST['jam_pelajaran']) ? $_POST['jam_pelajaran'] : null;

          $tgl = date("Y-m-d");

          $resultAbsensi = mysqli_query($koneksi, "SELECT * FROM absensi WHERE id_kelas='$id_kelas' AND date_created='$date_created' AND jam_pelajaran='$jam_pelajaran' AND id_guru='$guru_id'");
          ?>
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Daftar siswa </h6>
            </div>
            <div class="card-body">
              <?php
              // Ambil nama mapel dari tabel 'mapel' berdasarkan id_mapel
              $queryMapel = mysqli_query($koneksi, "SELECT nama_mapel FROM mapel WHERE id_mapel='$jam_pelajaran'");
              $dataMapel = mysqli_fetch_assoc($queryMapel);
              $nama_mapel = $dataMapel['nama_mapel'];

              // Tampilkan informasi pada judul
              echo "<h2 class='mb-2 text-gray-800'>Absensi $nama_kelas ($date_created)</h2>";
              echo "<h4 class='mb-4 text-primary'>Jam Pelajaran ke: $jam_pelajaran ($nama_mapel)</h4>";
              echo "";
              ?>
              <form role="form"
                action="simpanabsensi.php?id=<?php echo $id_kelas ?>&date_created=<?php echo $date_created ?>&jam_pelajaran=<?php echo $jam_pelajaran ?>"
                method="POST" name="postform" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr align="center">
                        <th>No</th>
                        <th>Profil</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <?php
                      $sql = "SELECT * FROM siswa WHERE id_kelas='$id_kelas'";
                      $query = mysqli_query($koneksi, $sql);
                      $i = 1;
                      while ($data = mysqli_fetch_array($query)) {
                        $nis = $data["nis"];
                        $nama = $data["nama"];
                        ?>
                        <tr>
                          <td>
                            <?= $i++; ?>
                          </td>
                          <td><i class="bi bi-person-circle mt-1" style="font-size: 32px;"></i></td>
                          <td>
                            <?= $nis; ?>
                          </td>
                          <td>
                            <?= $nama; ?>
                          </td>
                          <td>
                            <label class="radio-inline">
                              <input type="radio" name="<?= 'ket' . $data["nis"]; ?>"
                                id="<?php echo 'opsi1' . $nis; ?>_Hadir" value="Hadir">Hadir
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="<?= 'ket' . $data["nis"]; ?>"
                                id="<?php echo 'opsi2' . $nis; ?>_Absen" value="Absen">Absen
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="<?= 'ket' . $data["nis"]; ?>"
                                id="<?php echo 'opsi3' . $nis; ?>_Sakit" value="Sakit">Sakit
                            </label>
                            <label class="radio-inline">
                              <input type="radio" name="<?= 'ket' . $data["nis"]; ?>"
                                id="<?php echo 'opsi4' . $nis; ?>_Izin" value="Izin">Izin
                            </label>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
                <button type="submit" class="btn btn-primary mt-4 col-md-2 offset-10">Simpan Data</button>
              </form>
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