<?php
include 'crawl.php';
$crawler = new crawl();
if($_POST['crawl']) $crawler->crawlBerita($_POST['kategori']);
if($_POST['hapus'] && $_POST['id']) $crawler->hapusBerita($_POST['id']);