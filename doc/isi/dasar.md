### DASAR FRAMEWORK

#### DIREKTORI

struktur direktori

- `cfg`  konfigurasi mysql dan default route
- `core` berisi kumpulan kelas-kelas dasar 
- `ctrl` berisi kumpulan kelas-kelas controller
- `lib`  kelas-kelas tambahan
- `model` berisi kumpulan kelas model / query
- `smarty` kelas dari smarty (3rdparty)
- `tmp` hasil compiler dan cache dari smarty
- `tpl` template
- `upl` tempat mengunggah file asset ( image dan lainnya )


---

.


#### POLA REQUEST

Pola request untuk framework ini adalah

    http://www.seruji.com/index.php?u=controller/method/qry[0].../qry[n]  
    
atau
    
    http://www.seruji.com/?u=controller/method/qry[0].../qry[n]  
    
kita singkat selanjutnya 
    
    ?=u

Controller default adalah Content atau ditentukan dengan `$route` dalam cfg/base.php.

Apabila controller tidak ditemukan maka request dianggap sebagai method dari controller default-nya, atau menjadi

    ?u=method/qry[0]../qry[n]

atau sama dengan memanggil

    ?u=content/method/qry[0]../qry[n]
    
Method default adalah `index()`

Maka apabila method diatas tidak ditemukan, maka request dianggap memanggil method index() dari sebagai qry, sehingga untuk request

    ?u=qry[0]../qry[n]
    

sama dengan memanggil 

    ?u=content/index/qry[0]../qry[n]
    
    
    
    
Aturan ini berlaku sama juga untuk request kosong  atau dalam hal ini maka halaman **home/beranda** sama dengan


    ?u=content/index


----

.

#### HUBUNGAN ANTARA CONTROLLER DAN TEMPLATE

Setiap controller akan mempunyai kumpulan file template dalam direktori `tpl/controller` 

Setiap method defaultnya akan mempunyai template `tpl/controller/method.html`

Halaman **home/beranda** defaultnya adalah `Content->index()`, 
maka template untuk halaman **home/beranda** adalah `tpl/content/index.html`

Contoh Lainnya misalnya request

    ?u=reporter/login
    
maka dari request itu  berarti

  - controllernya adalah `Reporter`
  - methodnya adalah `login()`
  - maka templatenya adalah `tpl/reporter/login.htm`
    

---

.


#### ATURAN PENAMAAN KELAS

Aturan penamaan untuk kelas yaitu `NamaKelas` atau `Namakelas` ( First Capital ), disimpan dalam file `namakelas.php` ( LowerCase ).


---

.

##### akhir dasar framework