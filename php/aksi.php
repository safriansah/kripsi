<?php
include 'crawl.php';
$crawler = new crawl();
if($_POST['crawl']) $crawler->crawlBerita($_POST['kategori']);
if($_POST['hapus']) $crawler->hapusBerita($_POST['id']);
header("location:../neo.php");