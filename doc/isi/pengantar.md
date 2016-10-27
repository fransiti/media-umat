## PENGANTAR

#### Tentang Koio dan Kredit

Koio adalah Framework PHP dibuat yang mengikuti pola MVC( Model View Controller ).

Koio menggunakan beberapa komponen

- Smarty Template Engine Versi 3.1.19 [(http://www.smarty.net)](http://www.smarty.net),
- JQuery Versi 1.10.2 [(jQuery Foundation, Inc. | jquery.org)](http://www.jquery.org)
- Twitter Bootstrap CSS Framework Versi 3.1.1 [(github.com/twbs/bootstrap)](https://github.com/twbs/bootstrap)
- Ajaxupload Versi 3.5 [(vallums.com/ajax-upload)](http://valums.com/ajax-upload/)

Dokumentasi ini menggunakan markdown.js untuk parsing file .md  ke format html [(https://github.com/evilstreak/markdown-js)](https://github.com/evilstreak/markdown-js)

...

#### Permintaan Sistem

Webserver lengkap

- Apache 2 [.2.22]
- PHP 5.3 [.10]
- PHPMyAdmin 3.4 [.10.1]
- MySQL 5.5[.38]

Untuk pemakai Windows 7 dapat menggunakan webserver Xampplite/Xampp

...

#### Pola Request

Koio mempunyai pola request :

    index.php?u=object/method/query../query

Dari request diatas Koio akan menetapkan :

- `Object` adalah nama model (file  `./app/model/object.php`).
- `ObjectController` adalah nama controller (file `./app/control/objectcontroller.php`).
- `method($query .. $query)` adalah nama metod dari `ObjectController` yang dipanggil.
- `app/view/object/method.tpl` adalah nama file template yang digunakan


Apabila tidak ditemukan kelas `ObjectController` atau `method(query..query)` maka akan dikembalikan kepada nilai `$default` yang ditetapkan dalam file `./app/config/base.php`

Bila model `Object` ditemukan, otomatis akan menjadi properti milik `ObjectController`.

Contoh request

    index.php?u=admin/kirim/1

Dari request tersebut maka

- `Admin` adalah nama kelas model-nya (file `./app/model/admin.php`).
- `AdminController` adalah nama kelas controller-nya (file `./app/control/admincontroller.php`)
- `kirim(1)` adalah method dari `AdminController` yang dipanggil
- `app/view/admin/kirim.tpl` adalah file template-nya.

Lihat selengkapnya dalam [Referensi/Controller](isi/referensi/controller.md).

...


#### OOP Dan Database

Karena tujuan awal Koio adalah para pemula atau
programer PHP yang terbiasa memakai pendekatan 'prosedural'
agar mereka mudah memahami dan mempelajari alur sebuah framework MVC maka

- Koio tidak memakai *Singleton* dan *NameSpace* untuk kelas-kelas dasarnya.
- Kelas Model dalam membentuk query masih memakai fungsi-fungsi `mysql_***` alias
fungsi yang konon telah *deprecated* ( tapi tenang saja ..!, nggak usah panik ).

Koio memakai rutin `ob_start("ob_gzhandler")` atau
mengembalikan request dalam bentuk kompresi bila *client browser* mampu menangani
kompresi gzip semacam Mozilla Firefox 
