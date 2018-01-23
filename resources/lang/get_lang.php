<?php
/* for language settings

*/

if (isset($_GET['lang'])) {
    $_lang = $_GET['lang'];
    setcookie('_lang', $_lang, time() + 9999 * 9999, "/jhogroupware/");


} else {
    if (isset($_COOKIE['_lang'])) {
        $_lang = $_COOKIE['_lang'];
    } else {
        $_lang = 'ko-kr';
        setcookie('_lang', $_lang, time() + 9999 * 9999, "/jhogroupware/");

    }
}
$file_server_path = realpath(__FILE__);
$server_path = str_replace(basename(__FILE__), "", $file_server_path);
$data_str = file_get_contents($server_path . 'lang.json');
$json = json_decode($data_str, true);

$lang = array();
$lang = $json[$_lang];






