<?php
include 'crawl.php';
$crawler = new crawl();
$crawler->crawlBerita($_POST['kategori']);
header("location:../neo.php");