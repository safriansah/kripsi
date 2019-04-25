<?php
class crawl{
    var $koneksi;
    var $kategori;
    var $kategoriUrl;
    var $existUrl;
    var $table;

    function setKoneksi($koneksi, $table){
        $this->koneksi=$koneksi;
        $this->table=$table;
    }
    
    function hapusBerita($id){
        $query="delete from $this->table where id='$id'";
        $hasil="Data gagal dihapus";
        if(mysqli_query($this->koneksi, $query)) $hasil="Data berhasil dihapus";
        echo (" <script>
                    window.alert('$hasil');
                    window.location.href='../';
                </script>");
    }

    function crawlBerita($kategori){
        $this->kategori=$kategori;
        $this->existUrl="";
        $data = mysqli_query($this->koneksi,"select url from $this->table where kategori='".$kategori."'");
        while($d = mysqli_fetch_array($data)){
            $this->existUrl.=$d['url']." ";
        }
        
        if($kategori=="ekonomi") $this->kategoriUrl="https://ekonomi.kompas.com/search/all/";
        else if($kategori=="olahraga") $this->kategoriUrl="https://bola.kompas.com/search/all/";
        else if($kategori=="teknologi") $this->kategoriUrl="https://tekno.kompas.com/search/all/";
        else if($kategori=="entertainment") $this->kategoriUrl="https://entertainment.kompas.com/search/all/";
        
        if($kategori=="ekonomi") $hasil=$this->getEkonomi();
        else $hasil=$this->getUrl();
        echo (" <script>
                    window.alert('Berhasil mendapatkan $hasil berita pada kategori $kategori');
                    window.location.href='../';
                </script>");
    }

    function getUrl(){
        $halaman=1;
        $jumlah=0;
        while($jumlah<10){
            $kodeHTML =  file_get_contents($this->kategoriUrl.$halaman);
            $pecah = explode('<a class="article__link" href="', $kodeHTML);
            $i=0;
            foreach($pecah as $a){
                if($i==0){
                    $i++;
                    continue;
                }
                $a=explode('"', $a);
                $i++;
                if(!$this->cekKata($this->existUrl, $a[0])){
                    mysqli_query($this->koneksi, $this->getBerita($a[0]));
                    $jumlah++;
                }
            }
            $halaman+=1;
        }
        return $jumlah;
    }

    function cekKata($string, $kata){
        $hasil=false;    
        if(strpos(strtolower($string), strtolower($kata)) !== false) {
            $hasil=true;
        }
        return $hasil;
    }

    function getBerita($url){
        $kodeHTML = file_get_contents($url);
        $pecah = explode('<h1 class="read__title">', $kodeHTML);
        $judul = explode('</h1>', $pecah[1]);
        $judul = $judul[0];
        $pecah = explode('<div class="read__content">', $kodeHTML);
        $isi = explode('<div class="fb-quote">', $pecah[1]);
        $isi = $isi[0];
        if($this->cekKata($isi, "<strong>")){
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
        $isi = str_replace("'"," ",$isi);
        $isi = str_replace('"',' ',$isi);
        $query="insert into $this->table values('','$url','$judul','$isi','$this->kategori',NOW())";
        return $query;
    }

    function getEkonomi(){
        $halaman=1;
        $jumlah=0;
        while($jumlah<7){
            $kodeHTML =  file_get_contents($this->kategoriUrl.$halaman);
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
                if(!$this->cekKata($this->existUrl, $a[0])){
                    mysqli_query($this->koneksi, $this->getBerita($a[0]));
                    $jumlah++;
                }
            }
            $halaman+=1;
        }
        return $jumlah;
    }
    
}
    
