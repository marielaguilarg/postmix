<?php


// define constants
define('PROJECT_DIR', realpath('./'));
define('LOCALE_DIR', PROJECT_DIR .'/locale');
define('DEFAULT_LOCALE', 'es_ES');




$encoding = 'UTF-8';
// if(isset($_GET["lan"]))
//     {
//     if($_GET["lan"]=="en")
//          $_SESSION["idiomaus"]=2;
//     else
//             $_SESSION["idiomaus"]=1;
    
// }
$locale = (isset($_SESSION["idiomaus"])&&$_SESSION["idiomaus"]==2)? "en_US" : DEFAULT_LOCALE;


// gettext setup
T_setlocale(LC_MESSAGES, $locale);
// Set the text domain as 'messages'
$domain = 'MENconsultaResultados';
T_bindtextdomain($domain, LOCALE_DIR);
T_bind_textdomain_codeset($domain, $encoding);
T_textdomain($domain);
//echo $locale;

//----------------------------
// incializo variables y librerias para traduccion
//--------------------------------------------------

// define constants
// include ('libs/php-gettext-1.0.12/gettext.inc');
// define('PROJECT_DIR', realpath('./'));
// define('LOCALE_DIR', PROJECT_DIR .'/locale');
// define('DEFAULT_LOCALE', 'es_ES');

// //require_once('php-gettext-1.0.11/gettext.inc');

// $encoding = 'UTF-8';
// if(isset($_GET["lan"]))
//     {
//     if($_GET["lan"]=="en")
//      $_SESSION["idiomaus"]=2;
//     else
//         $_SESSION["idiomaus"]=1;

// }
// echo $_SESSION["idiomaus"];
// $locale = (isset($_SESSION["idiomaus"])&&$_SESSION["idiomaus"]==2)? "en_US" : DEFAULT_LOCALE;

// //if(isset($_SESSION["idiomaus"])&&$_SESSION["idiomaus"]==2)
// //    $locale="en_US";
// // lang puede ser en_US o es_Es de acuerdo a la carpetas en "local"
// // gettext setup
// T_setlocale(LC_MESSAGES, $locale);
// // Set the text domain as 'messages'

// //echo LOCALE_DIR;
// $domain = 'MENconsultaResultados';
// T_bindtextdomain($domain, LOCALE_DIR);
// T_bind_textdomain_codeset($domain, $encoding);
// T_textdomain($domain);
// //----------------------------------------------
// echo _("ESTADO");
?>
