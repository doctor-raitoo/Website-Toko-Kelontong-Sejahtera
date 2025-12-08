<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

if (!isset($_GET['tanggal'])) {
    die("Tanggal tidak ditemukan.");
}

$tanggal = $_GET['tanggal'];

include('koneksi.php');

list($d,$m,$y) = explode('/', $tanggal);
$tgl_sql = "$y-$m-$d";

$sql = $conn->prepare("SELECT * FROM transaksi WHERE DATE(waktu_transaksi) = ?");
$sql->execute([$tgl_sql]);
$data = $sql->fetchAll(PDO::FETCH_ASSOC);

require('fpdf/fpdf.php');

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->Cell(190,10,'LAPORAN PENJUALAN HARIAN',0,1,'C');
$pdf->Ln(10);

$pdf->SetFont('Arial','',12);
$pdf->Cell(190,7,"Tanggal: $tanggal",0,1);

$pdf->Ln(5);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,8,'#',1);
$pdf->Cell(60,8,'Nama Produk',1);
$pdf->Cell(20,8,'Jumlah',1);
$pdf->Cell(40,8,'Harga Satuan',1);
$pdf->Cell(40,8,'Total Harga',1);
$pdf->Ln();

$pdf->SetFont('Arial','',10);

$no = 1;
$total_barang = 0;
$total_pendapatan = 0;

foreach ($data as $row) {

    $stmt = $conn->prepare("SELECT nama_produk, harga FROM produk WHERE id = ?");
    $stmt->execute([$row['produk_id']]);
    $produk = $stmt->fetch(PDO::FETCH_ASSOC);

    $nama = $produk['nama_produk'];
    $qty = $row['qty'];
    $harga = $produk['harga'];
    $total = $row['total_harga'];

    $total_barang += $qty;
    $total_pendapatan += $total;

    $pdf->Cell(10,8,$no++,1);
    $pdf->Cell(60,8,$nama,1);
    $pdf->Cell(20,8,$qty,1);
    $pdf->Cell(40,8,"Rp ".number_format($harga),1);
    $pdf->Cell(40,8,"Rp ".number_format($total),1);
    $pdf->Ln();
}

$pdf->Ln(10);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,7,'Ringkasan Penjualan',0,1);

$pdf->SetFont('Arial','',11);
$pdf->Cell(190,6,"Total barang terjual: $total_barang",0,1);
$pdf->Cell(190,6,"Total pendapatan hari ini: Rp ".number_format($total_pendapatan),0,1);

$pdf->Output();
