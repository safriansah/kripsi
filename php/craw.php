<?php
include 'koneksi.php';
if($_POST['simpan']){
    $kategori=$_POST['kategori'];
    if($kategori=="ekonomi") $url="https://ekonomi.kompas.com/search/all/";
    else if($kategori=="bola") $url="https://bola.kompas.com/search/all/";
    else if($kategori=="tekno") $url="https://tekno.kompas.com/search/all/";
    else if($kategori=="entertainment") $url="https://entertainment.kompas.com/search/all/";
    getUrl($koneksi, $kategori, $url, 1, 1);
}
header("location:../");

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

function getBerita($koneksi, $url, $kategori){
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
    $query="insert into tb_berita values('','$url','$judul','$isi','$kategori')";
    mysqli_query($koneksi, $query);
    //echo $query."<hr>";
}

function getUrl($koneksi, $kategori, $url, $page, $jumlah){
    $kodeHTML =  bacaHTML($url.$page);
    $pecah = explode('<a class="article__link" href="', $kodeHTML);
    $i=0;
    foreach($pecah as $a){
        if($i==0){
            $i++;
            continue;
        }
        $a= explode('"', $a);
        $i++;
		$jumlah++;
		getBerita($koneksi, $a[0], $kategori);
    }
    if($jumlah<10) getUrl($koneksi, $kategori, $url, $page++, $jumlah);
}
?>

