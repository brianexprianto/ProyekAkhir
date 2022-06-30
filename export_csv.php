<?php
// Load file koneksi.php
include "configuration/config_connect.php";

// Load plugin PHPExcel nya
require_once 'PHPExcel/PHPExcel.php';

// Panggil class PHPExcel nya
$csv = new PHPExcel();

// Settingan awal fil excel
$csv->getProperties()->setCreator('IDwares')
					   ->setLastModifiedBy('Indotory Pro Plus')
					   ->setTitle("Data Barang")
					   ->setSubject("Barang")
					   ->setDescription("Data Barang Hasil Export Csv")
					   ->setKeywords("Data Barang");

// Buat header tabel nya pada baris ke 1
$csv->setActiveSheetIndex(0)->setCellValue('A1', "NO"); // Set kolom A1 dengan tulisan "NO"
$csv->setActiveSheetIndex(0)->setCellValue('B1', "Kode"); // Set kolom B1 dengan tulisan "NIS"
$csv->setActiveSheetIndex(0)->setCellValue('C1', "NAMA"); // Set kolom C1 dengan tulisan "NAMA"
$csv->setActiveSheetIndex(0)->setCellValue('D1', "Harga Beli"); // Set kolom D1 dengan tulisan "JENIS KELAMIN"
$csv->setActiveSheetIndex(0)->setCellValue('E1', "Harga Jual"); // Set kolom E1 dengan tulisan "TELEPON"
$csv->setActiveSheetIndex(0)->setCellValue('F1', "Keterangan"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('G1', "Kategori"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('H1', "Terjual"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('I1', "Terbeli"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('J1', "Sisa"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('K1', "No"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('L1', "Barcode"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('M1', "Brand"); // Set kolom F1 dengan tulisan "ALAMAT"
$csv->setActiveSheetIndex(0)->setCellValue('N1', "Avatar"); // Set kolom F1 dengan tulisan "ALAMAT"

// Buat query untuk menampilkan semua data siswa
$sql = mysqli_query($conn, "SELECT * FROM barang");

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 2
while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
	$csv->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
	$csv->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['kode']);
	$csv->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['nama']);
	$csv->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['hargabeli']);
	$csv->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['hargajual']);
	$csv->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['keterangan']);
	$csv->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['kategori']);
	$csv->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['terjual']);
	$csv->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['terbeli']);
	$csv->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['sisa']);
	$csv->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['no']);
	
	
	// Khusus untuk no telepon. kita set type kolom nya jadi STRING
	$csv->setActiveSheetIndex(0)->setCellValueExplicit('L'.$numrow, $data['barcode'], PHPExcel_Cell_DataType::TYPE_STRING);
	
	$csv->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data['brand']);
	$csv->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $data['avatar']);
	
	$no++; // Tambah 1 setiap kali looping
	$numrow++; // Tambah 1 setiap kali looping
}

// Set orientasi kertas jadi LANDSCAPE
$csv->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$csv->getActiveSheet(0)->setTitle("Laporan Data Barang");
$csv->setActiveSheetIndex(0);

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Data Barang.csv"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$write = new PHPExcel_Writer_CSV($csv);
$write->save('php://output');
?>
