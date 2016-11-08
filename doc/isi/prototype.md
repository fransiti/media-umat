###  PROTOTYPE

#### KONSEP DASAR

Berita, mempunyai struktur yang umum dipakai adalah

- Pengirim
- Tanggal dan jam berita dirilis.
- Foto yang berkaitan dengan berita
- Judul Berita.
- Isi berita, yang dibagi menjadi dua yaitu isi lengkap berita dan ekserp, yang dapat berupa alinea pertama atau abstraksi.

Macam macam berita

- Foto Utama dan tulisan
- Video
- Fragmen atau berseri, ini biasanya adalah  liputan khusus
- Profil atau fitur tentang sesuatu ( Tokoh, ResepMasakan dll.


Sedangkan berita dilihat dari alurnya adalah

- Dikirim oleh reporter/kontributor/koresponden
- Evaluasi oleh redaksi dan penyuntingan kata/bahasa
- Translate bila rilis akan di jadikan multi lingual ( opsional untuk pengembangan )



#### BAGAN ALUR WEB



[![img/bagan-alur-web.jpg](img/bagan-alur-web.jpg)](img/bagan-alur-web.jpg)


**Deskripsi**


Alur web dibagi menjadi 6 Grup Controller yaitu 

1. Reporter (file `ctrl/reporter.php`), atau dalam bagan debagai alur ** `A` **

    - Reporter adalah halaman untuk contributor/reporter/jurnalis atau 
    siapa saja yang ingin mengirimkan berita.

    - Reporter mempunyai akun terpisah dengan admin, 
    dan reporter bisa membuat akun baru bila belum mempunyai akun.
    
    - Untuk interface reporter diusahakan merupakan *mimick* dari halaman 
    mailbox sedapat mungkin mirip, untuk kemudahan para jurnalis yang biasa 
    berkirim berita melalui email.
    


2. Redaktur/Admin (file `ctrl/redaktur.php`) atau dalam bagan sebagai alur ** `B` **

    - Redaktur / Admin adalah halama-halaman untuk redaktur, 
    pimred, ulama/staf ahli, editor dan bagian tatausaha. 
    
    - Redaktur dan lain-lain tidak bisa membuat akun sendiri, namun dibuatkan oleh admin level pimred.
    
    - Level dibagi mnejadi empat yaitu level 1 untuk pimred dan menurun sampai bagian tatausaha
    
    - Level 1 atau pimred yang mempunyai wewenang membuat/mengubah rubrik/menu

3. Content (`ctrl/content.php`) dalam bagan sebagai alur ** `C` **

    - Content adalah controller default
    
    - method `index()` adalah method default atau **home** yang berisi list tayang ( C1 )

    - Content adalah halaman-halaman untuk pembaca
    
    - Halaman utama/home/beranda adalah index yang berisi list tayang(C1).
    Berisi headlines dan update berita paling baru.
    
    - List Rubrik adalah halaman yang menampilkan list untuk kelompok rubrik tertentu
    
    - List Profil adalah opsional, bisa disertakan atau tidak.
    
    - profil adalah halaman berisi profil reporter/pengirim berita. Bisa merupakan footage, modal-dialog atau 
    menuju ke satu halaman sendiri ( membuat sebuah method lagi misalnya `profil()` )
    Ini penting untuk mengikat reporter mengirimkan berita yang benar-benar dapat dipertanggung-jawabkan.
    
    
4. TataUsaha (`ctrl/tatausaha.php`) dalam bagan sebagai alur ** `D` **

    - Ini adalah halaman untuk bagian tatausaha, halaman ini berisi statistik dan 
    pemeritahuan pembayaran, termasuk traffic untuk rilis berita.
    
    - Traffic dan lain-lainnya dihubungkan dengan ajax untuk menjamin traffic lebih akurat
    daripada dikirim dalam controller. Selain itu agar compatible kalau nantinya dikembangkan 
    untuk API maupun feeder.


5. Api (`ctrl/api.php`)

    - ini adalah controller untuk API dengan format json, xml dan sebuah feeder (xml) untuk rss.
    - halaman ini tidak terlihat

6. Asset (`ctrl/asset.php`)
    
    - Link ke file media baik untuk link ekternal maupun internal( image/).
    - halaman ini tidak terlihat
    
7. Ads ( `ctrl/ads.php`)

    - Antarmuka untuk trafic 
    - halaman ini tidak terlihat
    
    
Untuk no. 5 sampai 7 tidak tampak dalam bagan karena tidak mempunyai interface, meskipun demikian ketiga alur tersebut
mempunyai template.


Setiap kelompok kecuali Content akan menjadi subdomain misalnya untuk `www.seruji.com` 
maka akan mempunyai sebuah domain dengan 7 buah subdomain yaitu

- www.seruji.com  untuk  `Content`
- reporter.seruji.com untuk `Reporter`
- redaktur.seruji untuk redaktur
- tatausaha.seruji untuk tatausaha
- api.seruji.com untuk API 
- asset.seruji.com
- ads.seruji.com


Dalam hubungan dengan template, maka masing masing alur tersebut mempunyai beberapa template misalnya controller ** `A` **
mempunyai template ** `A1` ** .. ** `A14` **

Dalam hubungan dengan method, template diatas merupakan interface untuk sebuah method.

.

**Kelompok Kerja bisa dibagi dengan opsi**
 
- kerja mengikuti per-controller tersebut.
- pembagian file perfolder misalnya `ctrl` dengan `tpl` atau webdevelop dan webdesign 
- pembagian tugas `developer`, `bug tester`, `security tester` dan `dokumentasi`

Untuk API atau keperluan aplikasi(*apk,webOs dll*) menyusul nanti bila prototype sudah menjadi proyek

---------------

.


#### BAGAN DATABASE


Berikut ini adalah prototype database Media Umat

.


[![img/bagan-database.jpg](img/bagan-database.jpg)](img/bagan-database.jpg)
    
.

**Deskripsi**

Database diatas apabila dihubungkan dengan controller maka 

1. Reporter menggunakan tabel 

    - draft   tabel data kiriman ( file `model/draft.php`)
    - ctraccess tabel untuk login (file `model/ctraccess.php`)
    - ctrprofile tabel untuk data diri pengirim (file `model/ctrprofile.php`)

    
2. Admin menggunakan semua tabel

4. Content menggunakan tabel

    - rilis data rilis ( dipindahkan dari tabel draft yang telah di-approve)
    - rubrik tabel untuk navigasi menu
    - ctrprofile untuk menampilkan data pengirim
    

4. Tatausaha menggunakan tabel 

    - admaccess untuk login
    - admprofile data login
    - ads tabel iklan yang dimuat dalam content.
    - adsclient data pemasang iklan
    - adstraffic data pengunjung halaman yang menampilkan iklan


-----

.

    
#### CONTOH PEMBUATAN CONTROLLER dan TEMPLATE    

**Reporter**

Reporter Menggunakan tabel/model :
    
- ctraccess table untuk login
- ctrprofile tabel untuk profil reporter/pengirim
- draft tabel untuk data kiriman
- drafturl tabel untuk konten kiriman
    

Reporter Mempunyai method-method 
( Setiap method `method()` mempunyai template `tpl/reporter/method.html` ) yaitu :
    
- A1 signup() halaman untuk membuat akun.
- A2 login()  halaman untuk melakukan login
- A3 profil() halaman untuk mengubah profil, boleh dipecah menjadi dua template yaitu 
    
    - halaman mengubah profil dan    
    - halaman untuk mengubah password 
    
.
    
- A4 payment() halaman untuk melihat kiriman yang telah dimuat berikut dengan nominal pembayaran dan hits(jumlah pembaca kirimannya)
- A3 listdraft() halaman setelah login berhasil, berisi daftar draft miliknya
- A5 edit() halaman untuk membuat atau mengubah draft 
- A6 hapus() halaman untuk hapus, memakai  konfirmasi, bisa melalui modal-dialog

Selain Template untuk diatas ada empat sub template yaitu template untuk isi dari draft yaitu

- A7 adalah template untuk kiriman tulisan.
- A8 adalah template untuk kiriman galery foto
- A9 adalah template untuk link ke video/youtube/vimeo
- A10 adalah berita fragment atau berita berseri 
- A11 adalah fitur misalnya untuk berita profil dsb

sub template diatas dapat dipanggil melalui javascript/jquery.ajax atau lainnya

**Langkah membuat Controller dan Template Untuk reporter.**

1. Buat folder `tpl/reporter` dan buat subfolder 

    - css  `tpl/reporter/css`
    - js   `tpl/reporter/js` 
    - img  `tpl/reporter/img`
    - fonts `tpl/reporter/fonts`

2. Buat file `ctrl/reporter.php` berisi sebuah class `Reporter`


        <?php
        /*
        hanya ada dua method untuk contoh
        */
        
        class Reporter extends BaseCtrl(){
            
            /*
            ini adalah contructor
            tujuannya agar inisialisasi model hanya kita tulis 
            sekali saja
            
            boleh tidak dipakai, tapi harus inisialisasi 
            model dalam tiap-tiap methodnya
            */
            
            
            function __construct(){
                parent::__construct();
                
                /* 
                inisialisasi tabel draft, 
                drafturl, ctraccess dan ctrprofile
                */
                $this->addModel('draft');
                $this->addModel('drafturl');
                $this->addModel('ctraccess');
                $this->addModel('ctrprofile');
                
                /*
                inisialisasi session ( session_start() )
                */
                $this->addModel('session');
                
            }
        
            /*
            method ini untuk menangani reporter/contrib membuat akun bila 
            belum mempunyai akun
            */
            
            function signup(){
                /*
                periksa apakah reporter mengirimkan data akun baru
                bila iya, simpan dalam ctrprofile dan ctraccess
                */
                if($this->_post->submitted()){
                    /* 
                    karena left join berdasar ctrprofile, 
                    maka masukkan dahulu data ke ctrprofile, 
                    dan id-nya dipakai untuk ctraccess
                    */
                    $this->ctrprofile->add($this->_post->all());
                    $idprofile=$this->ctrprofile->save();
                    
                    /* 
                    memasukkan email dan pwd 
                    serta ctrprofile_id ke ctraccess 
                    */
                    $this->ctraccess->add($this->_post->all());
                    $this->ctraccess->profile_id=$idprofile;
                    $this->ctraccess->save();
                    
                    /*
                    redirect ke halaman login
                    */
                    $this->redir('reporter/login');
                    }
            }
                    
            
            
        /* akhir kelas Reporter */            
        }
        
        
                       
3. Buat file template `tpl/reporter/signup.html` 

        <!doctype html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Sign Up</title>
        </head>
        <body>
            
        {*
            gunakan {$hta} agar template tidak tergantung dengan .htacess
            dalam action-nya
            
            gunakan required="required" untuk menghindari input kosong
            nama input sesuaikan dengan nama kolom tabel ctrprofile dan ctraccess
            ( lihat dalam `model/ctrprofile.php` dan `model/ctraccess` )
            
            
        *}
            
            <form name="form-signup" action="{$hta}reporter/login" method="post">
                <h4>Data Pribadi</h4>
                <label>Nama Lengkap</label><br>
                <input name="nama" type="text" required="required"><br>
                <label>Foto<label><br>
                <img src="{$hta}image/background/silver/120x90/jpg" id="img-file"><br>
                <input type="file" name="img-upload" id="img-upload"><br>
                <label>Profesi</label><br>
                <input type="text" name="profesi" required="required"><br>
                <textarea name="tentang" col="50" row="5"></textarea><br>
                <hr>
                <h4>Data untuk Login</h4>
                <label>email</label><br>
                <input type="text" name="email" required="required"><br>
                <label>Password</label><br>
                <input type="password" name="pwd" required="required"><br>
                <button type="submit" name="submit">Submit</button> 
            </form>    
                
        </body>
        </html>

4. Lanjutkan langkah diatas dengan 
    
    - edit file `ctrl/reporter.php` dan buat method berikutnya dari A2 sd A6
    - buat template dengan nama yang sesuai, misalnya A2 methodnya `login` buat templatenya `tpl/reporter/login.html`
    
    
-----

.

#### VARIABLE YANG TELAH DITENTUKAN UNTUK TEMPLATE


Variabel ditulis mengikuti sintaks dari [SMARTY](http://smarty.net) yaitu 
diapit dengan kurawal tanpa spasi atau `{..}`.

        

Gunakan Variabel request yang ditetapkan dibawah ini, untuk menghindari kesalahan yang mungkin 
terjadi akibat pada saat pembuatan dengan saat sudah berada dalam webhosting.


Variabel yang telah ditetapkan untuk yaitu :

- `{$hta}` sama dengan `index.php?u=` .

- `{$url}` akan menunjuk pada alamat itu sendiri.

        
- `{$baseurl}` akan menunjuk pada controllernya.


misalnya untuk  `index.php?u=reporter/login` maka 


        <form action="{$hta}reporter/login" method="post">
        
        {*
         sama dengan diatas adalah
        *}
        <form action="{$url}" method="post">
        
        {*
         sama dengan diatas juga adalah
        *}
        <form action="{$baseurl}/login" method="post">
        
        
            
- `{$sitename}` sama dengan $_SERVER['SERVER_NAME']
        

- `{$image}` untuk menampilkan alamat image atau `index.php?u=asset/image`.
misalnya menampilkan background dengan warna biru, 240px ekstensi jpg

        <img src="{$image}/background/blue/small/jpg">
        
        {*
        atau 
        *}
        
        <img src="{$image}/background/#0000FF/240x240/jpg">
        
        

- `{$css}`, `{$js}`, `{$img}`,`{$fonts}`) adalah direktori untuk folder css,js,img dan fonts.
misalnya

        <head>
        ...
            <link rel="favicon" href="{$img}/icon.png">
            <link rel="stylesheet" href="{$css}/bootstrap.min.css">
            <script type="text/javascript" src="{$js}/jquery.min.js"></script>
        ..
        </head>

-----

.


#### KETERANGAN 

Untuk detail penjelasan framework silahkan dilihat **BAGIAN DUA**



---------

.

##### akhir prototype