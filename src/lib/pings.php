<?php
class Pings{
    /*
    ini adalah kelas untuk ping/submit sitemap
    untuk semua mesin pencari
    */
    
    function google(){
        
    }
    
    function bing(){
        
    }
    
    function baidu(){
        
    }
        
    /*
    
    
    function pingGoogleSitemap ( $rootUrl ) {

    $fileName = "http://www.google.com/webmasters/sitemaps/ping?sitemap=" .urlencode("$rootUrl/sitemap.xml");

    $url = parse_url($fileName);
    if (!isset($url["port"])) $url["port"] = 80;
    if (!isset($url["path"])) $url["path"] = "/";

    $fp = @fsockopen($url["host"],
                     $url["port"],
                     &$errno, &$errstr, 30);

    if ($fp) {
        $head = "";
        $httpRequest = "HEAD ". $url["path"] ."?"
                     .$url["query"] ." HTTP/1.1\r\n"
                     ."Host: ". $url["host"] ."\r\n"
                     ."Connection: close\r\n\r\n";

        fputs($fp, $httpRequest);
        while(!feof($fp)) $head .= fgets($fp, 1024);
        fclose($fp);

        return $head;

    }

return "ERROR";
//*

}
}