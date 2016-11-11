<?php
class Img{
    /*
        ukuran 
    */
    protected $_size = array(
        'tiny'  =>'64',
        'thumb' =>'96',
        'small' =>'240',
        'medium'=>'520',
        'big'   =>'960',
        'large' =>'1280',
        'huge' =>'2560',
    );
    protected $_color= array(
        'aliceblue'=>'#f0f8ff',
        'antiquewhite'=>'#faebd7',
        'aqua'=>'#00ffff', 	  	
        'aquamarine'=>'#7fffd4', 	  	
        'azure'=>'#f0ffff',
        'beige'=>'#f5f5dc', 	  	
        'bisque'=>'#ffe4c4',
        'black'=>'#000000', 	  	
        'blanchedalmond'=>'#ffebcd', 	  	
        'blue'=>'#0000ff', 	  	
        'blueviolet'=>'#8a2be2', 	  	
        'brown'=>'#a52a2a', 	  	
        'burlywood'=>'#deb887', 	  	
        'cadetblue'=>'#5f9ea0', 	  	
        'chartreuse'=>'#7fff00', 	  	
        'chocolate'=>'#d2691e', 	  	
        'coral'=>'#ff7f50', 	  	
        'cornflowerblue'=>'#6495ed', 	  	
        'cornsilk'=>'#fff8dc', 	  	
        'crimson'=>'#dc143c', 	  	
        'cyan'=>'#00ffff', 	  	
        'darkblue'=>'#00008b', 	  	
        'darkcyan'=>'#008b8b', 	  	
        'darkgoldenrod'=>'#b8860b', 	  	
        'darkgray'=>'#a9a9a9', 	  	
        'darkgrey'=>'#a9a9a9', 	  	
        'darkgreen'=>'#006400', 	  	
        'darkkhaki'=>'#bdb76b', 	  	
        'darkmagenta'=>'#8b008b', 	  	
        'darkolivegreen'=>'#556b2f', 	  	
        'darkorange'=>'#ff8c00', 	  	
        'darkorchid'=>'#9932cc', 	  	
        'darkred'=>'#8b0000', 	  	
        'darksalmon'=>'#e9967a', 	  	
        'darkseagreen'=>'#8fbc8f', 	  	
        'darkslateblue'=>'#483d8b', 	  	
        'darkslategray'=>'#2f4f4f', 	  	
        'darkslategrey'=>'#2f4f4f', 	  	
        'darkturquoise'=>'#00ced1', 	  	
        'darkviolet'=>'#9400d3', 	  	
        'deeppink'=>'#ff1493', 	  	
        'deepskyblue'=>'#00bfff', 	  	
        'dimgray'=>'#696969', 	  	
        'dimgrey'=>'#696969', 	  	
        'dodgerblue'=>'#1e90ff', 	  	
        'firebrick'=>'#b22222', 	  	
        'floralwhite'=>'#fffaf0', 	  	
        'forestgreen'=>'#228b22', 	  	
        'fuchsia'=>'#ff00ff', 	  	
        'gainsboro'=>'#dcdcdc', 	  	
        'ghostwhite'=>'#f8f8ff', 	  	
        'gold'=>'#ffd700',
        'goldenrod'=>'#daa520', 	  	
        'gray'=>'#808080',
        'grey'=>'#808080',
        'green'=>'#008000',
        'greenyellow'=>'#adff2f', 	  	
        'honeydew'=>'#f0fff0',
        'hotpink'=>'#ff69b4',  	
        'indianred'=>'#cd5c5c',
        'indigo'=>'#4b0082',
        'ivory'=>'#fffff0',
        'khaki'=>'#f0e68c',
        'lavender'=>'#e6e6fa',
        'lavenderblush'=>'#fff0f5', 	  	
        'lawngreen'=>'#7cfc00',
        'lemonchiffon'=>'#fffacd', 	  	
        'lightblue'=>'#add8e6', 	  	
        'lightcoral'=>'#f08080', 	  	
        'lightcyan'=>'#e0ffff',
        'lightgoldenrodyellow'=>'#fafad2',
        'lightgray'=>'#d3d3d3', 	  	
        'lightgrey'=>'#d3d3d3', 	  	
        'lightgreen'=>'#90ee90', 	  	
        'lightpink'=>'#ffb6c1',
        'lightsalmon'=>'#ffa07a',
        'lightseagreen'=>'#20b2aa', 	  	
        'lightskyblue'=>'#87cefa', 	  	
        'lightslategray'=>'#778899', 	  	
        'lightslategrey'=>'#778899', 	  	
        'lightsteelblue'=>'#b0c4de', 	  	
        'lightyellow'=>'#ffffe0', 	  	
        'lime'=>'#00ff00', 	  	
        'limegreen'=>'#32cd32', 	  	
        'linen'=>'#faf0e6', 	  	
        'magenta'=>'#ff00ff', 	  	
        'maroon'=>'#800000', 	  	
        'mediumaquamarine'=>'#66cdaa',
        'mediumblue'=>'#0000cd',
        'mediumorchid'=>'#ba55d3', 	  	
        'mediumpurple'=>'#9370db', 	  	
        'mediumseagreen'=>'#3cb371', 	  	
        'mediumslateblue'=>'#7b68ee', 	  	
        'mediumspringgreen'=>'#00fa9a', 	  	
        'mediumturquoise'=>'#48d1cc', 	  	
        'mediumvioletred'=>'#c71585', 	  	
        'midnightblue'=>'#191970', 	  	
        'mintcream'=>'#f5fffa', 	  	
        'mistyrose'=>'#ffe4e1', 	  	
        'moccasin'=>'#ffe4b5', 	  	
        'Navajowhite'=>'#ffdead', 	  	
        'Navy'=>'#000080', 	  	
        'oldlace'=>'#fdf5e6', 	  	
        'olive'=>'#808000', 	  	
        'olivedrab'=>'#6b8e23', 	  	
        'orange'=>'#ffa500', 	  	
        'orangered'=>'#ff4500', 	  	
        'orchid'=>'#da70d6', 	  	
        'palegoldenrod'=>'#eee8aa', 	  	
        'palegreen'=>'#98fb98', 	  	
        'paleturquoise'=>'#afeeee', 	  	
        'palevioletred'=>'#db7093', 	  	
        'papayawhip'=>'#ffefd5', 	  	
        'peachpuff'=>'#ffdab9', 	  	
        'peru'=>'#cd853f',
        'pink'=>'#ffc0cb', 	  	
        'plum'=>'#dda0dd', 	  	
        'powderblue'=>'#b0e0e6',
        'purple'=>'#800080',
        'rebeccapurple'=>'#663399', 	  	
        'red'=>'#ff0000',	
        'rosybrown'=>'#bc8f8f', 	  	
        'royalblue'=>'#4169e1', 	  	
        'saddlebrown'=>'#8b4513', 	  	
        'salmon'=>'#fa8072', 	  	
        'sandybrown'=>'#f4a460', 	  	
        'seagreen'=>'#2e8b57', 	  	
        'seashell'=>'#fff5ee', 	  	
        'sienna'=>'#a0522d', 	  	
        'silver'=>'#c0c0c0', 	  	
        'skyblue'=>'#87ceeb', 	  	
        'slateblue'=>'#6a5acd', 	  	
        'slategray'=>'#708090', 	  	
        'slategrey'=>'#708090', 	  	
        'snow'=>'#fffafa', 	  	
        'springgreen'=>'#00ff7f', 	  	
        'steelblue'=>'#4682b4', 	  	
        'tan'=>'#d2b48c', 	  	
        'teal'=>'#008080', 	  	
        'thistle'=>'#d8bfd8', 	  	
        'tomato'=>'#ff6347', 	  	
        'turquoise'=>'#40e0d0', 	  	
        'violet'=>'#ee82ee', 	  	
        'wheat'=>'#f5deb3', 	  	
        'white'=>'#ffffff', 	  	
        'whitesmoke'=>'#f5f5f5', 	  	
        'yellow'=>'#ffff00', 	  	
        'yellowgreen'=>'#9acd32',
    );
    protected $_header= array(
        'jpeg'=>'Content-type: image/jpeg',
        'png'=>'Content-type: image/png',
        'jpg'=>'Content-type: image/jpeg',
        'gif'=>'Content-type: image/gif',
        );

    protected $_dir;
    protected $_webdir;
    protected $_width;
    protected $_height;
    /*
     image aslinya
     */
    protected $_imgfile;
    protected $_imgwidth;
    protected $_imgheight;
    protected $_imgtype;
    protected $_imgattr;
    
    private function extFromType($content_type){
        switch($content_type){
            case 'image/gif'  :return 'gif';
                break;
            case 'image/jpeg' :return 'jpg';
                break;
            case 'image/jpg'  :return 'jpg';
                break;
            case 'image/pjpeg':return 'jpg';
                break;
            case 'image/png'  :return 'png';
                break;
            case 'image/x-png':return 'png';
                break;
            default:return 0;    
        }
    }
    
    private function fromHex($img,$hexstr){
        $int = hexdec($hexstr);
        return imagecolorallocate($img,
                                   0xFF & ($int >> 0x10),
                                   0xFF & ($int >> 0x8),
                                   0xFF & $int);
    }
    private function setRes($res){
        if(isset($this->_size[$res])){
            $this->_width=$this->_size[$res];
            $this->_height=ceil($this->_imgheight*$this->_width/$this->_imgwidth);
        }else{
            $array=explode('x',$res);
            $this->_width=array_shift($array);
            if(!empty($array)){
                $this->_height=$array[0];
            }else{
                $this->_height=ceil($this->_imgheight*$this->_width/$this->_imgwidth);
            }
        }
    }
    function __construct(){
        if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);
        if(!defined('ROOT_DIR')) define('ROOT_DIR',dirname(dirname(__FILE__)));
        $this->_dir=ROOT_DIR.DS.'upl'.DS.'img';
        $this->_webdir='./upl/img';
    }
     function setDir($dir){
        $this->_dir=ROOT_DIR.DS.'upl'.DS.$dir;
        $this->_webdir='./upl/'.$dir;
        if(!is_dir($this->_dir)) mkdir($this->_dir);
    }
    
    function getDir($file=null){
        if(!empty($file)) $file=DS.$file;
        return $this->_dir.$file;
    }

    function getWebdir($file=null){
        if(!empty($file)) $file='/'.$file;
        return $this->_webdir.$file;
    }
    
    function check($file){
        $file=$this->_dir.DS.$file;
        $res=file_exists($file);
        if($res){
            $this->_imgfile=$file;
            list($this->_imgwidth,
                 $this->_imgheight,
                 $this->_imgtype,
                 $this->_imgattr)=getimagesize($file);
        }
        return $res;
    }

    
    function background($color='silver',$res='small',$ext='png'){
        
        if(isset($this->_size[$res])){
            $this->_width=$this->_size[$res];
            $this->_height=$this->_width;
        }else{
            $array=explode('x',$res);
            $this->_width=array_shift($array);
            $this->_height=empty($array)?$this->_width:$array[0];
        }
        if(!is_numeric($this->_width))  $this->_width='240';
        if(!is_numeric($this->_height)) $this->_height=$this->_width;
        
        if(isset($this->_color[$color])){
            $imgcolor=$this->_color[$color];
        }else{
            $array=explode('',$color);
            $imgcolor=$array[0]=='#'?$color:'#eaeaea';
        }
        
        $img=imagecreate($this->_width,$this->_height);
        $bg =$this->fromHex($img,$imgcolor);
        imagefilledrectangle($img,0,0,$this->_width,$this->_height,$bg);
        $ext=strtolower($ext);
        header($this->_header[$ext]);
        $function='image'.$ext;
        call_user_func($function,$img);
        imagedestroy($img);
    }
        
        
    private function imgPNG(){
        $des=imagecreatetruecolor($this->_width,$this->_height);
        $src=imagecreatefrompng($this->_imgfile);
        imagecopyresampled($des,$src,0,0,0,0,
                           $this->_width,$this->_height,$this->_imgwidth,$this->_imgheight);
        header($this->_header['png']);
        imagepng($des);
        imagedestroy($des);
        imagedestroy($src);
    }
    private function imgJPG(){
        $des=imagecreatetruecolor($this->_width,$this->_height);
        $src=imagecreatefromjpeg($this->_imgfile);
        imagecopyresampled($des,$src,0,0,0,0,
                           $this->_width,$this->_height,$this->_imgwidth,$this->_imgheight);
        header($this->_header['jpg']);
        imagejpeg($des);
        imagedestroy($des);
        imagedestroy($src);
    }
        
    private function imgGIF(){
        $des=imagecreatetruecolor($this->_width,$this->_height);
        $src=imagecreatefromgif($this->_imgfile);
        imagecopyresampled($des,$src,0,0,0,0,
                           $this->_width,$this->_height,$this->_imgwidth,$this->_imgheight);
        header($this->_header['gif']);
        imagegif($des);
        imagedestroy($des);
        imagedestroy($src);
    }
    
    function render($file,$res){
        $check=$this->check($file);
        if($check){
            $this->setRes($res); 
            switch($this->_imgtype){
                case 1:$this->imgGIF();
                    break;
                case 2:$this->imgJPG();
                    break;
                case 3:$this->imgPNG();
                    break;
                default:
                    $this->imgJPG();
            }            
        }else{
            $this->background('silver',$res,'jpeg');
        }
        
    }
    function post($img,$ext){
        if($ext=='png'){
            $s='data:image/png;base64,';
        }else{
            $ext='jpg';  
            $s='data:image/jpeg;base64,';
        }
        $file=uniqid().'.'.$ext;
        $img=str_replace($s,'',$img);
        $img=str_replace(' ','+',$img);
        $data=base64_decode($img);
        file_put_contents($this->_dir.DS.$file,$data);        
        return $file;
    }
    
    function save($file,$prefix='i_'){
        $ext=$this->extFromType($file['type']);
        $err=$file['error'];
        $name=$prefix.uniqid().'.'.$ext ;
        if( $ext != '0' && $err=='0' ){
            move_uploaded_file($file['tmp_name'], $this->_dir.DS.$name);
            return $name;
        }else{
            return 0;
        }
    }
    
    function delete($file){
        $imgfile=$this->_dir.DS.$file;
        if(file_exists($imgfile)){
            unlink($imgfile);
        }
    }
    
}