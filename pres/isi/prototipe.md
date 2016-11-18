#### PROTOTYPE DASAR



** POLA DASAR FRAMEWORK **

Prototype **SERUJI** mengikuti mazhab MVC (MODEL VIEW CONTROLLER).

![mvc](img/mvc.jpg)


dimana

- Model adalah bagian dapur / berhubungan langsung dengan server database, untuk **SERUJI** menggunakan MYSQL

- View adalah kumpulan template atau interface, 

- Controller adalah `logic bussines`-nya, mengambil/menyimpan data dan memilih template untuk ditampilkan 


#### ALUR DAN DESAIN  


[![bagan-alur](img/bagan-alur-web.jpg)](img/bagan-alur-web.jpg)



** ACESS CONTROL **

Ada empat `access controll` dalam administrasi SERUJI yaitu

- reporter : meliputi membuat dan mengatur akun miliknya sendiri

- redaktur : redaktur mempunyai empat kode level yaitu
    
    - Pimpinan Redaksi
    - Staf Khusus yaitu semacam majelis pertimbangan
    - Redaktur
    - Bagian Tatausaha

.

- tatausaha : untuk pemasang iklan dengan level 

    - public 
    - member/biro/agen
    
- asset : resource (misal: file streaming, feeder, sitemap, dll ) untuk cross domain mempunyai adalah publik, baik untuk *back-end* maupu *front-end* dan *read-only*

-- penjelasan // masuk ke dalam bank nasabah reporter belum daftar daftar, nulis rekening, asset adalah aqua/brosur di dalam bank
   pimred adalah pimp bank 

.

.

.
---
