<?php
class Video{
    function youtube($url,$res='',$allow_full=''){
        /*
        $array=explode('x',$res);
        $width=array_shift($array);
        $height=(empty($array))? ceil($res*3/4):$res[0];
        */
        parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
        $youtube= '<iframe allowtransparency="true" scrolling="no" width="'.'100%'.'" height="'.'100%'.
            '" src="//www.youtube.com/embed/'.$my_array_of_vars['v'].
            '" frameborder="0"'.($allow_full?' allowfullscreen':'').
            '></iframe>';
        return $youtube;
    }
        
}
