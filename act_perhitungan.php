<?php

// Database configuration

include "configuration/config_connect.php";

$HariKerja = 100;

$TahunBanding = date("Y", strtotime('-1 year'));

$sqleoq = mysqli_query($conn, "SELECT S.kode_barang, SUM(s.jumlah) AS JumlahPesan, s.lead_time AS lead_time , MAX(s.jumlah) AS MaxJumlahPesan,AVG(s.jumlah) AS AvgJumlahPesan, s.biaya_pesan AS BiayaPesan, b.biaya_simpan AS BiayaSimpan, b.hargajual AS hargajual, t.tgl FROM stok_masuk_daftar s LEFT JOIN barang b ON s.kode_barang = b.kode LEFT JOIN stok_masuk t ON s.nota = t.nota WHERE Year(t.tgl) = '$TahunBanding' GROUP BY s.kode_barang asc");
while ($row = mysqli_fetch_array($sqleoq)) {

	
$kode = $row['kode_barang'];

$JumlahPesan = $row['JumlahPesan'];

$MaxJumlahPesan = $row['MaxJumlahPesan'];


$AvgJumlahPesan = $row['AvgJumlahPesan'];
//var_dump($row['JumlahPesan']);
//var_dump($row['MaxJumlahPesan']);
//var_dump($row['AvgJumlahPesan']);


$lead_time = $row['lead_time'];
$total_biaya_simpan = $row['hargajual'] * $row['BiayaSimpan'];
// var_dump($total_biaya_simpan);


$Eoq = 2*$row['JumlahPesan']*$row['BiayaPesan']/$total_biaya_simpan;
$EoqAkhir= round(sqrt($Eoq));

$SafetyStock = ($MaxJumlahPesan - $AvgJumlahPesan) * $lead_time;

$demand = $AvgJumlahPesan / 30;
$Rop = ($lead_time*$demand)+$SafetyStock;


$Frekuensi = round($JumlahPesan/$EoqAkhir);


$RangeAkhir =  $HariKerja/1;

$sql_update = "UPDATE barang SET eoq = '$EoqAkhir',stokmin = '$Rop',safety_stok = '$SafetyStock', frekuensi = '$Frekuensi', range_beli = '$RangeAkhir' where kode = '$kode' ";
			$query = mysqli_query($conn, $sql_update);
}
header('location: barang_perhitungan.php');
?>