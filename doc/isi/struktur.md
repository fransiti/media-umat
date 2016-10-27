## STRUKTUR

PHP Framework untuk Media Umat 

- *index.php*
- *cfg/db.php* konfigura
- **app** direktori untuk **'produktifitas'** terdiri dari
    - *config* : direktori file-file pengaturan
        - *base.php*  -> file pengaturan dasar
        - *db.php*   ->  file pengaturan koneksi dengan mysql
        - *html.php*   ->  file pengaturan template header dan footer
    - *control* : direktori tempat controller yang nanti anda buat
        - *simplecontroller.php* -> file contoh controller sederhana
        ( lihat [Tutorial/Sederhana](isi/tutorial/sederhana.md) )
    - *model* : direktori untuk model
        - *simple.php*  -> contoh model sederhana
    - *view* : direktori untuk kumpulan folder-folder template
        - *share*  -> direktori untuk file *header.tpl* dan *footer.tpl*
        - *simple*  -> direktori template untuk contoh sederhana
    - *helper*  : direktori helper untuk file template
        - *contoh.php*  -> file contoh helper
    - *lib* : direktori untuk library
        - *cookie.php*  -> file kelas Cookie
        - *image.php*  -> file kelas Image
        - *pdf.php*  -> file kelas PDF
        - *post.php*  -> file kelas Post
        - *session.php*  -> file kelas Session
- **doc** direktori dokumentasi yang anda baca sekarang
    - *index.html*
    - *sidebar.html*
    - *isi* direktori file-file dokumentasi
    - *smarty-doc* direktori dokumentasi resmi dari **Smarty** yang kami sertakan
- **public** direktori untuk semua file pendukung, **Twitter Bootstrap Css Framework** dan **JQuery** ada disini
    - *css*
    - *fonts*
    - *img*
    - *js*
    - *upl* : direktori untuk upload file
        - *img*  -> direktori default untuk upload image ( kelas Image ).
        - *doc*  -> direktori default untuk upload pdf ( kelas PDF ).
- **system**
    - *core* : direktori untuk file-file kelas dasar
    - *dbase* : direktori untuk file kelas dasar dbase
    - *incl* : direktori untuk file-file rutin
    - *smarty* : direktori untuk file-file kelas Smarty
    - *tmp* : direktori kerja untuk Smarty dan error.log
- **tutor** direktori source untuk tutorial yang ada dalam dokumentasi
