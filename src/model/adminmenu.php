<?php
class AdminMenu{
    /* 
    icon sesuaikan dengan menu level 1
    icon ini berdasar pada glyphicon halflings
    bila menggunakan lainnya sila disesuaikan
    */
    protected $_icon  = array(
        'profiles'=>'home',
        'accounts'=>'user',
        'menu'=>'list-alt',
        'rilis'=>'flag',
        'submit'=>'check',
        'draft'=>'file',
    );

    /* menu */
    protected $_level = array(
        '1'=> array(
            'profiles'=>'Profil',
            'accounts'=>'Akun',
            'menu'=>'Menu',
            'rilis'=>'Rilis',
            'submit'=>'Submit Draft',
            'draft'=>'Draft',
        ),
        '2'=> array(
            'rilis'=>'Rilis',
            'submit'=>'Kiriman',
            'draft'=>'Draft',
        ),
        '3'=> array(
            'draft'=>'Draft',
        ),
    );
    
    
    function getIcon(){
        return $this->_icon;
    }
    
    function getLevel($level){ 
        return $this->_level[$level];
    }
        
}