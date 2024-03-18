<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id_kelas = $_GET['kelas'];
	$nis = $_GET['nis'];

	$berhasil = true;

	foreach ($_POST as $key => $value) {
		// Memastikan hanya data keterangan yang diubah yang diproses
		if (strpos($key, 'ket') !== false) {
			$id_absensi = substr($key, 3); // Mengambil id_absensi dari nama input
			$ket = mysqli_real_escape_string($koneksi, $value);

			$sql_absen = "UPDATE `absensi` SET `keterangan` = '$ket' WHERE `id_absen` = $id_absensi AND `id_kelas` = $id_kelas AND `nis` = '$nis'";

			if (!mysqli_query($koneksi, $sql_absen)) {
				$berhasil = false;
				echo 'gagal';
			}
		}
	}

	if ($berhasil) {
		echo '<script>alert("Ubah Data Berhasil");</script>';
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rekapabsensi.php?kelas=' . $id_kelas . '">';
	} else {
		echo '<script>alert("Ubah Data Gagal"); history.go(-1);</script>';
	}
}
