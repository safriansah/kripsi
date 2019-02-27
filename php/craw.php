<?php
include 'koneksi.php';

if($_POST['crawl']){
    crawlBerita($koneksi);
}

if($_POST['reset']){
    resetTabel($koneksi);
}
header("location:../");

function resetTabel($koneksi){
    mysqli_query($koneksi, "TRUNCATE TABLE tb_berita");
}

function crawlBerita($koneksi){
    $kategori=$_POST['kategori'];
    $eurl="";
    $data = mysqli_query($koneksi,"select url from tb_berita where kategori='".$kategori."'");
    while($d = mysqli_fetch_array($data)){
        $eurl.=$d['url']." ";
    }
    if($kategori=="ekonomi") $url="https://ekonomi.kompas.com/search/all/";
    else if($kategori=="olahraga") $url="https://bola.kompas.com/search/all/";
    else if($kategori=="teknologi") $url="https://tekno.kompas.com/search/all/";
    else if($kategori=="entertainment") $url="https://entertainment.kompas.com/search/all/";
    if($kategori=="ekonomi") getEkonomi($koneksi, $kategori, $url, 1, 1, $eurl);
    else getUrl($koneksi, $kategori, $url, 1, 1, $eurl);
    //echo $kategori." ".$url." ".$eurl;
}

function bacaHTML($url){
    // inisialisasi CURL
    $data = curl_init();    
    
    // setting CURL
    curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($data, CURLOPT_URL, $url);
    
    // menjalankan CURL untuk membaca isi file
    $hasil = curl_exec($data);
    curl_close($data);
    
    return $hasil;
}

function cekKata($string, $kata){
    $hasil=false;    
    if(strpos(strtolower($string), strtolower($kata)) !== false) {
        $hasil=true;
    }
    return $hasil;
}

function getBerita($url, $kategori){
    //$kodeHTML =  bacaHTML($url);
    $kodeHTML = file_get_contents($url);
    $pecah = explode('<h1 class="read__title">', $kodeHTML);
    $judul = explode('</h1>', $pecah[1]);
    $judul = $judul[0];
    $pecah = explode('<div class="read__content">', $kodeHTML);
    $isi = explode('<div class="fb-quote">', $pecah[1]);
    $isi = $isi[0];
    if(cekKata($isi, "<strong>")){
        $isiBagi = explode('<strong>', $isi);
        $isi="";
        $a=0;
        foreach ($isiBagi as $i){
            if($a==0) $isi.=$i;
            else{
                $isiBagiLagi = explode('</strong>', $i);
                $isi.=$isiBagiLagi[1];
            }
            $a++;
        }
    }
    include 'koneksi.php';
    $isi = str_replace("'"," ",$isi);
    $isi = str_replace('"',' ',$isi);
    $query="insert into tb_berita values('','$url','$judul','$isi','$kategori',NOW())";
    //mysqli_query($koneksi, $query);
    return $query;
}

function getUrl($koneksi, $kategori, $url, $page, $jumlah, $exist){
    while($jumlah<10){
        $kodeHTML =  bacaHTML($url.$page);
        //$kodeHTML = file_get_contents($url.$page);
        $pecah = explode('<a class="article__link" href="', $kodeHTML);
        $i=0;
        foreach($pecah as $a){
            if($i==0){
                $i++;
                continue;
            }
            $a=explode('"', $a);
            $i++;
            if(!cekKata($exist, $a[0])){
                mysqli_query($koneksi, getBerita($a[0], $kategori));
                //echo $a[0];
                $jumlah++;
            }
        }
        echo $page." : ".$jumlah."<hr>";
        $page+=1;
    }
}

function getEkonomi($koneksi, $kategori, $url, $page, $jumlah, $exist){
    while($jumlah<10){
        $kodeHTML =  bacaHTML($url.$page);
        //$kodeHTML = file_get_contents($url.$page);
        $pecah = explode('<div class="terkini__post">', $kodeHTML);
        $i=0;
        foreach($pecah as $a){
            if($i==0){
                $i++;
                continue;
            }
            $a=explode('<a href="', $a);
            $a=explode('"', $a[1]);
            $i++;
            if(!cekKata($exist, $a[0])){
                mysqli_query($koneksi, getBerita($a[0], $kategori));
                //echo $a[0];
                $jumlah++;
            }
        }
        echo $page." : ".$jumlah."<hr>";
        $page+=1;
    }
}
?>