<?php
$host="localhost";
$user="root";
$pass="";
$db="db_kripsi_dummy";
$table="tb_berita";

$koneksi = mysqli_connect($host, $user, $pass, $db);
 
// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}

include 'crawl.php';
$crawler = new crawl();
$crawler->setKoneksi($koneksi, $table);
?>
