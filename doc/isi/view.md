## TEMPLATE


#### KELAS VIEW

Apabila controller diturunkan dari BaseCtrl, maka kelas view telah diinisialisas dalam property $_view

Method-method dari View antara lain

- set($nama\_variabel,$nilai\_variabel) untuk meletakkan variabel dalam template

- setTpl($nama\_template) mengganti file template dari template defaultnya. $nama\_template tanpa extensi.
Default filetemplate adalah nama methodnya misalnya controller Admin, methodnya login(), maka templatenya adalah `./tpl/admin/login.html`
       
- setDir($dir) mengganti direktori template 

contoh  
    
        /* 
        merubah direktori template dan file template menjadi
        tpl/lain/halaman.html
        */   
        $this->_view->setDir('lain');
        $this->_view->setTpl('halaman');
        
        
- fetch() template hanya dirender dalam buffer

        // jangan merender template lagi
        $this->_render=false;
        
        $buffer = $this->_view->fetch();
        echo $buffer;

- render() merender dan mengirimkan template ke browser, fungsi ini secara explisit tidak perlu dilakukan, 
karena controller otomatis akan merender di akhir rutin (lihat method ` __destruct()` dalam `/ctrl/basectrl.php`)

#### TEMPLATE

Kelas View merender template dengan menggunakan [http://www.smarty.net](Smarty Template Engine), maka penulisan sintaks 
yang akan diparsing mengikuti aturan dari Smarty. 

Smarty memparsing {} (kurawal tanpa spasi) dimanapun letaknya dalam template. Problem yang seringkali muncul adalah kalau kita menuliskan 
inline script dalam template. sedangkan eksternal file tidak diparsing, kecuali yang memakai {include file="namafile.html"}

berikut ini contoh penulisan script yang ditolak
        
        {* ini ditolak*}
        <script>
            $(function()){$('.btn').click(function(e){console.log('clicked');})}
        </script>
        {* ini juga ditolak meskipun kurawal memakai spasi *}
        <script>
            $(function()){ $('.btn').click(function(e){ console.log('clicked'); }) }
        </script>

tulis script  seperti ini

        <script>
            $(function({
                $('.btn').click(function(e){
                    console.log('clicked');
                });
            }))
        </script

{$var} akan diparsing oleh smarty

        <script>
            $(function(){
                $('.btn').click{
                    var i = "{$var}";
                    console.log(i);
                } 
            });
            
Sintaks yang umum dipakai dalam smarty

- {$var}  sama dengan perintah php  `<?php echo $var; ?>`

- {$var.nama}, {$var['nama']} sama dengan `<?php echo $var['nama']; ?>`

- {$var.nama.subnama}, {$var\['nama'].subnama} atau {$var.nama\['subnama']}  sama dengan `<?php echo $var['nama']['subnama'];?>`

- {\*  \*}  sintaks untuk menuliskan komentar

- {if $var eq 1 } .. {/if} atau {if $var=1} .. {else} .. {/if} sama dengan <?php if($var=1){ ?> .. <?php } ?>

- {foreach $var as $key=>$val} .. {/foreach} sama dengan <?php foreach($var as $key=>$val){ ?> .. <?php } ?> 




Dari template sudah ada variabel yang siap dipakai yaitu

- {$hta} atau `?=u` dibutuhkan bila nanti mengunakan pretty_url htaccess.

- {$baseurl} atau `?u=nama_kelas/nama_method`

- {$url} atau sama dengan `$_GET['u']` 


Path relatif untuk script dan style menurut foldernya

- {$css} path untuk file css

- {$js} path untuk file js

- {$img} path untuk file img, ini bukan direktori upload untuk image, melainkan untuk image tambahan seperti image untuk loading dll

- {fonts} path untuk fonts


---
##### akhir TEMPLATE

