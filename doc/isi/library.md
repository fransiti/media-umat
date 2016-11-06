## LIBRARY

#### SESSION

Kelas ini untuk menangani session

methodnya adalah

- set($key, $value) untuk menyimpan variabel ke dalam session, 
    `$key` bisa berupa array `$subkey => $subval` dimasukkan menjadi `$_SESSION[$subkey]` 
    
- all() mengambil semua nilai session
    
- get($key) untuk mengambil nilai dari session, apabila `$key` kosong maka sama dengan `all()` , 
mengembalikan `false` bila `$key` tidak ditemukan
    
- newId() sama dengan `session_regenerate_id()`
    
- id()  sama dengan `session_id()`
    
.

#### POST
    
Kelas untuk menangani post;

Post telah di inisialisasi dalam BaseCtrl menjadi properti $\_post. Sedangkan global `$_POST` telah dibersihkan dari buffer.

method-methodnya 

- submitted($key)  memeriksa apakah ada post atau tidak berdasarkan `$key` atau `$_POST[$key]`, 
    bila `$key` kosong maka yang diperiksa adalah `$_POST['submit']`.
    
- set($key,$val) menambahkan variabel untuk memanipulasi `$_POST`
- get($key) mengambil nilai `$_POST[$key]` nilai false untuk $key yang tidak ditemukan
- all() mengambil semua `$_POST`

.

#### COOKIE

Kelas untuk menangani $_COOKIES

Mempunyai method
    
- expired($hour)  mengatur waktu kadaluarsa cookie, `$hour` dalam jam.
- set($key, $value) menyimpan nilai dalam cookie  `$_COOKIE[$key]`.
- get($key) mengambil nilai sebuah cookie, atau bila `$key` kosong mengambil seluruh `$_COOKIE`
- all() mengambil seluruh `$_COOKIE`
- close() menghapus seluruh `$_COOKIE`
- createToken($key) mebuat token dengan sha1, token disimpan ke `$_COOKIE[$key]`,
bila `$key` kosong, disimpan ke `$_COOKIE['token']`

.

        
#### PDF

Kelas untuk menangani file tipe pdf. Termasuk menampilkan thumbnail dalam format jpg dengan bantuan imagemagick, 
untuk develop di local server under windows dan memakai xampp, lihat apakah xampp menyertakan modul imagemagick. 
sedangkan untuk pengguna linux, imagemagick tidak mengalami masalah karena sudah termasuk package default.

Method dari kelas PDF

- setDir($dir) mengatur tempat penyimpanan file 
- getDir() menampilkan direktori asli. relatif dengan root.

- save($file, $preffix) mengunggah file, nama disimpan dengan `uniqid()` sedangkan 
preffix adalah awalan sebelum nama file dengan default `'p'`. Mengembalikan nama file bila berhasil.

- thumbnail($file,$width) menampilkan halaman pertama dengan format jpg. default width adalah 120px. 
- delete($file) menghapus file.

.        

#### IMG

*Kelas Image sudah dibuatkan Controllernya, lihat ctrl/image.php*


Kelas untuk menangani image, image yang didukung adalah jpg, gif dan png.

Method-methodnya yaitu

- setDir($dir) direktori untuk upload image 
- getDir($dir) menampilkan direktori relative terhadap root
- check($file) memeriksa apakah file image ada atau tidak

- background($color,$resolusi,$extension), menampilkan image kosong dengan warna `$color`, sebesar `$resolusi` dan ekstensi yang diminta.
`$color` dapat berisi nilai hexa atau valid nama color misalnya silver,aqua,red dll ( lihat property `$_color` dalam **lib/img.php** ).
resolusi dapat berupa format` width x height` misalnya `200x100` akan menampilkan lebar 200px dan tinggi 100px, atau hanya lebar misalnya `200`,
atau dengan salah satu kata `tiny,thumb,small,medium,large,huge`. 

- save($file, preffix) menyimpan file image, file disimpan dengan nama `uniqid()` dengan preffix `$preffix`
- post($postimg, extension) menyimpan file image yang dikirim melalui post httpuri.(64 based encoded). 
Misalnya dari capture canvas. Contoh penggunaan, lihat **tpl/admin/image-crop.html** sebagai pengirim 
dan **ctrl/image.php**  sebagai penerima export canvas. extension adalah ekstensi yang diinginkan.

- render($file,$resolusi) Menampilkan image dengan resolusi `$resolusi`, 
nilai resolusi bisa dengan ukuran `width` untuk height menurut aspek rasio, atau stretch dengan ukurab `width x height`, 
atau dengan salah satu kata `tiny,thumb,small,medium,large,huge` , height akan ditampilkan sesuai aspek rasio.

- delete($file) menghapus file image 

---

.

##### akhir library