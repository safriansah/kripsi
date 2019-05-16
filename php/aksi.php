<?php
error_reporting(0);
include 'koneksi.php';
if($_POST['crawl']) $crawler->crawlBerita($_POST['kategori']);
if($_POST['hapus'] && $_POST['id']) $crawler->hapusBerita($_POST['id']);