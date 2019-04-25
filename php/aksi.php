<?php
error_reporting(0);
include 'crawl.php';
include 'koneksi.php';
$crawler = new crawl();
$crawler->setKoneksi($koneksi, $table);
if($_POST['crawl']) $crawler->crawlBerita($_POST['kategori']);
if($_POST['hapus'] && $_POST['id']) $crawler->hapusBerita($_POST['id']);