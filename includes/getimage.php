<?php
function youtube_thumbnail_url($url)
{
if(!filter_var($url, FILTER_VALIDATE_URL)){
    // URL is Not valid
    return false;
}
$domain=parse_url($url,PHP_URL_HOST);
if($domain=='www.youtube.com' OR $domain=='youtube.com') // http://www.youtube.com/watch?v=t7rtVX0bcj8&feature=topvideos_film
{
    if($querystring=parse_url($url,PHP_URL_QUERY))
    {  
        parse_str($querystring);
        if(!empty($v)) return "$v";
        else return false;
    }
    else return false;
 
}
elseif($domain == 'youtu.be') // something like http://youtu.be/t7rtVX0bcj8
{
    $v= str_replace('/','', parse_url($url, PHP_URL_PATH));
    return (empty($v)) ? false : "$v" ;
}
 //http://i1.ytimg.com/vi/dEwxyabYHFE/mqdefault.jpg
else
 
return false;
}
//$v=parse_str( parse_url( $url, PHP_URL_QUERY ) );
//echo  $v;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
