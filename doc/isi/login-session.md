## CONTOH LOGIN SESSION

Berikut ini adalah contoh halaman login, dengan menggunakan kelas Session.
validasi login menggunakan tabel tbakun.

#### MODEL

Buat model untuk tabel tbakun  **model/tbakun.php**

        <?php
        class Tbakun extends Model{
            /* kolom-kolomnya selain id */
            protected $columns = array(
                'nama'=>'VARCHAR(128)',
                'pwd'=>'VARCHAR(128)',
            );
            
            /* data pertama */
            protected $firstdata = array(
                array (
                    'nama' => 'admin',
                    'pwd'  => 'admin'
                )
            ); 
        
        /* akhir Akun */
        }
            
.

#### CONTROLLER

Buat sebuah controller Akun **ctrl/akun.php**

Akun mempunyai dua buah method, yaitu index dan login

        <?php
            
            class Akun extends BaseCtrl{
                protected $_login=false;
                
                
                function index(){
                    $this->addModel('session');
                    /*
                    periksa session login
                    */
                    $this->_login=$this->session->get('login')==$this->session->id();
                    /*
                    belum login redirect ke index
                    */
                    if(!$this->_login) $this->redir('akun/login');
                    /*
                    tampilkan detail akun 
                    login
                    */
                    $this->_view->set('akun',$this->session->all());
                }
                    
                function login(){
                    $this->addModel('session');
                    /*
                    check bila sudah login 
                    redirect ke index
                    */
                    if($this->_login) $this->redir('akun');
                    
                    $message='Silahkan Login';    
                    /*
                    check kiriman data login
                    */
                    if($this->_post->submitted()){
                            $this->addModel('tbakun');
                            $all=$this->_post->all();
                            /* 
                            beri nilai sembarang untuk post kosong 
                            */
                            foreach($all as $key=>$val)
                              if empty($all[$key]) $all[$key]=uniqid();
                            /*
                            cocokkan akun
                            */
                            $this->tbakun->add($all);
                            $akun=$this->tbakun->select();
                            $count=$this->tbakun->countRec();
                            /* 
                            akun cocok 
                            masukkan akun ke session
                            buat session baru
                            redirect ke index
                            */
                            if($count>0){
                                $this->session->set($akun[0]);
                                $this->session->set('login',$this->session->newId());
                                $this->redir('akun');
                            }
                            /*
                            akun tidak ada 
                            */
                            $message='Login Salah, periksa akun dan password';
                        }
                        $this->_view->set('message',$message);
                        
                    }
                        
                        
            
            /* akhir Akun */
            }


#### TEMPLATE

Controller mempunyai dua buah method, semuanya menggunakan template, maka kita buat dua template 
yaitu index.html untuk login berhasil dan login untuk form mengirim data login

- buat template **tpl/akun/index.html**
    
                
                <!doctype html>
                <html>
                    <head>
                        <meta charset="UTF-8">
                        <title>Contoh Login dengan Session</title>
                    </head>
                    <body>
                        <h2>Ini adalah Halaman Index</h2>
                        Selamat Datang
                        <hr>
                        <pre>
                        {* hanya print_r saja.. *}
                        
                        {print_r($akun)}
                        </pre>
                    </body>
                </html>
                
- buat template **tpl/akun/login.html

                <!doctype html>
                <html>
                    <head>
                        <meta charset="UTF-8">
                        <title>Contoh Login dengan Session</title>
                    </head>
                    <body>
                        <h2>Login</h2>
                        {* message *}
                        {$message}
                        <hr>
                        <form name="form-login" action="{$url}" method="post">
                        <label>Nama</label><br>
                        <input type="text" name="nama" required="required" placeholder="masukkan nama"><br>
                        
                        <label>password</label><br>
                        <input type="password" name="pwd" requird="required" placeholder="password"><br>
                        <input type="submit" name="submit" value="Login">
                        </form>
                    </body>
                </html>
