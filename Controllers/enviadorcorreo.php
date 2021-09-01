<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

include 'libs/PHPMailer/PHPMailer.php';
include 'libs/PHPMailer/Exception.php';
include 'libs/PHPMailer/SMTP.php';


class EnviadorCorreo
{
    public $mail;
    
    
    function __construct() {
        $this->mail = new PHPMailer(true);
         $host="";
        
    }
   
    public function crearCuenta(){
        $usename="alertas.postmix@muesmerc.com.mx";
        $password="a5390lert";
        $port=465;
        $debug=false;
        $host="mail.muesmerc.mx";
        //Server settings
        if($debug)
         $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = $host;                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = $username;                     //SMTP username
        $this->mail->Password   = $password;                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $this->mail->Port       = $port;  
        
    }
}

