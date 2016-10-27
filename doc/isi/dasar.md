## BAB I.DASAR

#### DIREKTORI

direktori-direktorinya berisi

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

    /?u=controller/method/qry[0].../qry[n]    

apabila controller tidak ditemukan maka dianggap sebagai method dari kelas defaultnya
yang telah tentukan dengan $route dalam file cfg/base.php sehingga menjadi

    /?=method/qry[0]../qry[n]

contohnya, dalam cfg/base.php ditentukan $route='admin' maka 

    /?=login
    
karena tidak ditemukan kelas Login,maka dianggap memanggil method dari kelas Admin atau
sama dengan 

    <?php
    
        $admin=new Admin;
        $admin->login();

.

#### CONTROLLER

Letakkan file controller dalam /ctrl

Apabila controller diturunkan dari `BaseCtrl` maka akan didapat variabel-variabel
yang telah di inisialisasi yaitu

- $_view : kelas View 
- $_post : kelas Post
- $_render : Apakah disalin ke template atau tidak, default 1(true)

Dan variabel yang diteruskan untuk template tanpa garis bawah

- $_baseurl : nama_kelas/nama_method  ( diteruskan dalam template sebagai{$baseurl} )
- $_qry  : array dari qry[0].. 
- $_hta  : `?u=` 
- $_url  : Request asli ( `$_GET['u']` )
- $_header : title dan subtitle untuk template
- $_meta   : meta untuk template


Method-method dalam kelas ini

- createMenu() : inisialisasi variabel $menu untuk template, berisi data menu dari tabel menu (`model/menu.php`)
- pagination($halaman_ini,$jumlah_record,$vartotpl) : membuat paginasi, $vartotpl adalah
variabel untuk template mempunyai nilai default `{$pagination}`

    - $pagination['first'] : halaman awal 
    - $pagination['prev'] : halaman sebelum halaman_ini
    - $pagination['next'] : halaman setelah ini
    - $pagination['page'] : halaman ini
    - $pagination['last'] : halaman terakhir atau jumlah halaman
    - $pagination['rec_count'] : jumlah record
    
.    
   
- redir(url) untuk redirect dengan `header('location: url')` serta membuang semua Post
- setUrl() untuk menganti nilai $_url
- setMeta() untuk mengganti/menambah meta
- setHeader() untuk mengganti/menambah header
- addModel(nama_kelas) cara aman untuk menambahkan kelas sebagai anggota
- notfound() menampilkan http 404 not found

.

---
##### akhir BAB I.DASAR