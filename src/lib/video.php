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
/*
notes regex
 	abc… 	Letters
	123… 	Digits
	\d 	Any Digit
	\D 	Any Non-digit character
	. 	Any Character
	\. 	Period
	[abc] 	Only a, b, or c
	[^abc] 	Not a, b, nor c
	[a-z] 	Characters a to z
	[0-9] 	Numbers 0 to 9
	\w 	Any Alphanumeric character
	\W 	Any Non-alphanumeric character
	{m} 	m Repetitions
	{m,n} 	m to n Repetitions
	* 	Zero or more repetitions
	+ 	One or more repetitions
	? 	Optional character
	\s 	Any Whitespace
	\S 	Any Non-whitespace character
	^…$ 	Starts and ends
	(…) 	Capture Group
	(a(bc)) 	Capture Sub-group
	(.*) 	Capture all
	(abc|def) 	Matches abc or def
*/
    function tipeVideo( $url ){
        $url = preg_replace('#\#.*$#', '', trim($url));
        $services_regexp = array(
            "#^\w+\.(?P<format>[a-zA-Z0-9]{2,5})#"                     => 'local',
            '#vimeo\.com\/(?P<id>[0-9]*)[\/\?]?#i'                     => 'vimeo',
            '#youtube\.[a-z]{0,5}/.*[\?&]?v(?:\/|=)?(?P<id>[^&]*)#i'   => 'youtube',
    );

        foreach ( $services_regexp as $pattern => $service ) {
            if ( preg_match ( $pattern, $url, $matches ) ) {
            //    return ( $service === 'local' ) ? $matches['format']  : $service;
                return $service;
            }
    }
        return false;
    }
        
}
