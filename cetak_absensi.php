<?php
require('./fpdf/fpdf.php');
session_start();
include "koneksi.php";

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['kelas'])) {
    $id_kelas = $_GET['kelas'];

    $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : null;
    $queryNamaKelas = mysqli_query($koneksi, "SELECT nama_kelas FROM kelas WHERE id_kelas='$id_kelas'");
    $dataNamaKelas = mysqli_fetch_array($queryNamaKelas);
    $nama_kelas = $dataNamaKelas['nama_kelas'];

    class PDF extends FPDF
    {
        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
        }
    }

    $pdf = new PDF('L');
    $pdf->AddPage();
    $pdf->SetMargins(25, 15, 25);
    $pdf->SetFont('helvetica', 'B', 20);
    $pdf->Cell(0, 10, 'Rekap Absensi Kelas ' . $nama_kelas, 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Ln(7);

    $pdf->Cell(10, 10, 'No', 1, 0, 'C');
    $pdf->Cell(40, 10, 'NIS', 1, 0, 'C');
    $pdf->Cell(60, 10, 'Nama', 1, 0, 'C');

    $whereClause = '';
    if (!empty($tanggal)) {
        $whereClause = " AND date_created='$tanggal'";
    }

    $queryTanggal = mysqli_query($koneksi, "SELECT DISTINCT date_created, jam_pelajaran FROM absensi WHERE id_kelas='$id_kelas' $whereClause");

    while ($dataTanggal = mysqli_fetch_array($queryTanggal)) {
        $pdf->Cell(45, 10, $dataTanggal['date_created'] . ' ' . '(ID Mapel:' . $dataTanggal['jam_pelajaran'] . ')', 1, 0, 'C');
    }
    $pdf->Ln();

    $querySiswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_kelas='$id_kelas'");
    $no = 1;
    while ($dataSiswa = mysqli_fetch_array($querySiswa)) {
        $pdf->Cell(10, 10, $no++, 1, 0, 'C');
        $pdf->Cell(40, 10, $dataSiswa['nis'], 1, 0);
        $pdf->Cell(60, 10, $dataSiswa['nama'], 1, 0);

        $queryAbsensi = mysqli_query($koneksi, "SELECT keterangan FROM absensi WHERE id_kelas='$id_kelas' AND nis='{$dataSiswa['nis']}' $whereClause");

        while ($dataAbsensi = mysqli_fetch_array($queryAbsensi)) {
            $pdf->Cell(45, 10, $dataAbsensi['keterangan'], 1, 0, 'C');
        }

        $pdf->Ln();
    }

    // Cek jika jumlah siswa melebihi jumlah maksimal dalam satu halaman
    $maxRowsPerPage = 30;
    $numRows = mysqli_num_rows($querySiswa);
    $remainingRows = $numRows - ($pdf->PageNo() - 1) * $maxRowsPerPage;

    if ($remainingRows > 0) {
        $pdf->AddPage();
        $pdf->Ln(10);
    }

    $pdf->Output();
} else {
    header("Location: rekapabsensi.php");
    exit;
}
?>