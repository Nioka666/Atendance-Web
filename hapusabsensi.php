<?php
	include "koneksi.php";
	$id_kelas=$_GET['id'];
	$tgl_absen=$_GET['date_created'];
	
    $sql="DELETE FROM absensi WHERE id_kelas='$id_kelas' AND date_created='$tgl_absen'";
	
	
	
	if($res_siswa=mysqli_query($koneksi,$sql)){
		?> <script>alert('Hapus Data Berhasil')</script><?php
		echo '<META HTTP-EQUIV="Refresh" Content="0; URL=rekapabsensi.php?kelas='.$id_kelas.'">';		
	}else{
		?> <script>alert('Simpan Data Gagal');history.go(-1);</script><?php		
	}
	
?>