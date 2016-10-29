## DASAR

#### DIREKTORI

struktur direktori

- `cfg`  konfigurasi mysql dan default route
- `core` kelas-kelas dasar 
- `ctrl` kelas-kelas controller
- `lib`  kelas-kelas tambahan
- `model` kelas-kelas query
- `smarty` kelas dari smarty (3rdparty)
- `tmp` hasil compiler dan cache dari smarty
- `tpl` template
- `upl` media yang diunggah

.

#### POLA REQUEST

Pola request untuk framework ini adalah

    index.php?u=controller/method/qry[0].../qry[n]  

Controller default ditentukan dengan `$route` dalam cfg/base.php, sedangkan method default adalah `index()`.

Apabila controller tidak ditemukan maka request dianggap sebagai method dari controller defaultnya, atau menjadi

    ?u=method/qry[0]../qry[n]
    
Aturan ini berlaku sama juga untuk berikutnya sehingga $_GET['u'] kosong akan merujuk kepada controller dan method default.
Misalnya dalam cfg/base.php  nilai `$route` adalah `'content'`, berarti halaman home/beranda sama dengan

    <?php
        
        $content=new Content;
        $content->index();
        
.

Aturan penamaan untuk kelas yaitu `NamaKelas` atau `Namakelas` ( First Capital ), disimpan memakai `namakelas.php` ( LowerCase ).

.

#### CONTROLLER

File controller diletakkan dalam **ctrl/**

Apabila controller diturunkan dari `BaseCtrl` maka akan didapat properti-properti
yang telah di inisialisasi yaitu

- $_view : kelas View 
- $_post : kelas Post
- $_render : Apakah menampilkan template atau tidak, default 1(true) berarti menampilkan template.

Dan variabel-variabel yang diteruskan ke dalam template, 
( dalam template menjadi tanpa garis bawah )

- $\_baseurl : nama\_kelas/nama\_method  ( diteruskan dalam template sebagai{$baseurl} )
- $\_qry  : array dari qry[0].. 
- $\_hta  : `?u=` 
- $\_url  : Request asli ( `$_GET['u']` )
- $\_header : title dan subtitle untuk template
- $\_meta   : meta untuk template

Method-method dalam kelas ini

- createMenu() : inisialisasi variabel $menu untuk template, berisi data dari tabel menu (`model/menu.php`), 
nilai kembalian adalah array bertingkat atau kalau memakai `var_dump($this->createMenu())` hasilnya

        
        array (
            0 => array (
                'nama' => 'nama_satu',
                'url'  => 'url_satu',
                
                'submenu'=> 
                    0 => array (
                            'nama'=>'sub_satu',
                            'url' =>'urlsub_satu'
                    ),
                    1 => array (
                            'nama' => 'sub_dua',
                            'url' =>'urlsub_dua',
                    ),   
            ),
        );
        

- pagination($halaman\_ini,$jumlah\_record,$nama\_paginasi) : membuat paginasi, $nama\_paginasi adalah variabel 
untuk template dan mempunyai nilai default `{$pagination}`, banyaknya record perhalaman berdasar `$record_perpage` atau nilai `$db['rec']` 
dalam cfg/db.php

    - $pagination['first'] : halaman awal, nilai 0 bila halaman ini < 2
    - $pagination['prev'] : halaman sebelum halaman ini  nilai 0 bila  halaman ini < 3 
    - $pagination['page'] : halaman ini
    - $pagination['next'] : halaman setelah ini, nilai 0 bila  halaman ini > total-2 
    - $pagination['last'] : halaman , nilai 0 bila halaman ini > total-1
    - $pagination['rec\_count'] : jumlah record
    - $pagination['total'] : total halaman
    
    dibawah ini `var_dump` dengan $this->pagination(3,250);
    
            array(
                'first' => '1',
                'prev'  => '2',
                'page'  => '3',
                'next'  => '4',
                'last'  => '5',
                'rec_count' =>'250',
                'total' => '5',
            );
                
.    
   
- redir(url) sama dengan redirect dengan `header('location: url')` dengan mebuang semua $\_POST.
- setUrl() untuk menganti nilai $\_url
- setMeta() untuk mengganti/menambah meta
- setHeader() untuk mengganti/menambah header
- addModel(nama\_kelas) cara aman untuk menambahkan kelas sebagai anggota, nama\_kelas akan menjadi propertinya, misalnya

        $this->addModel('session');
        /* session menjadi nama propertinya */
        $this->session->..
        
.        

- notfound() menampilkan http 404 not found

.

---
##### akhir DASAR