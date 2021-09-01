<?php




include 'enviadorcorreo.php';

class CorreoAlertas extends EnviadorCorreo
{
    
    private  $edestinatario="patitoeu@gmail.com";
    private $destinatario="Marisol Vega";
    private $cc="patitoeu@hotmail.com";
    private $subject="Envio de alertas de muesmerc";
    private $urllogo="https://muesmerc.mx/postmixv3/img/logo_mues2020.png";
  
    public function crearCuerpo($tablas,$fecha){
        $inicio="<br>Estimado usuario.<br>
            
MUESMERC, desea comunicarle que el d&iacute;a de hoy <span id='fecha'>".$fecha."</span> se ha(n) generado la(s) siguiente(s) alertas por desviaci&oacute;n en la calidad de agua para el/los siguientes puntos de venta";
        
        $pie="Recuerde que puede descargar y compartir los documentos en PDF de estas alertas, desde nuestro sitio web, accediendo a la siguiente liga: <a href='https://muesmerc.mx/postmixv3/'>www.muesmerc.mx/postmixv3/</a>
       <br>   
 <br>     
    Sus claves de usuario son:
    <br>US: cic@cic.com
    <br>PWD: 6598
            
    <br>
<br>Gratos saludos.";
      
        $message='<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" 
 xmlns:v="urn:schemas-microsoft-com:vml"
 xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <!--[if gte mso 9]><xml>
   <o:OfficeDocumentSettings>
    <o:AllowPNG/>
    <o:PixelsPerInch>96</o:PixelsPerInch>
   </o:OfficeDocumentSettings>
  </xml><![endif]-->
  <!-- fix outlook zooming on 120 DPI windows devices -->
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- So that mobile will display zoomed in -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- enable media queries for windows phone 8 -->
  <meta name="format-detection" content="date=no"> <!-- disable auto date linking in iOS 7-9 -->
  <meta name="format-detection" content="telephone=no">
<style type="text/css">
body {
  margin: 0;
  padding: 0;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
}
 div{
    margin-top:20px;
 
width:80%;

}
span{
font-weight: bold;
font-size:18;

}
.tablaDatos, .tablaDatos thead,.tablaDatos td {

 margin-top:10px;
	border: 1px solid black;
 border-collapse: collapse; 
}
.titulo2{
 background-color:#E0E8F5;
width:15%;

}
.titulo1{
font-weight: bold;
 background-color:#E0E8F5;
text-align: center;
}

#fecha{
font-weight: bold;
font-size:14;
}

</style>
</head>

<body style="margin:0; padding:0;" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">'.
'
<!-- 100% background wrapper (grey background) -->
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#F0F0F0">
  <tr>
    <td align="center" valign="top" bgcolor="#F0F0F0" style="background-color: #F0F0F0;">

      <br>

      <!-- 600px container (white background) -->
      <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" style="width:600px;max-width:600px;background-color:#ffffff"">
       
        <tr>
          <td class="container-padding content" align="center" style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;background-color:#F0F0F0">
          ';
        
        $message .= " <img src='".$this->urllogo."'/>
</td>
   </tr>
   ";
        
        $message .= ' <tr>
          <td class="container-padding content" align="left" style="padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;font-family:Helvetica, Arial, sans-serif;font-size:14px;line-height:20px;text-align:left;color:#333333">
     '.$inicio."</td>
    </tr>
".$tablas."
<tr height='250' >
<td style='padding-left:24px;padding-right:24px;padding-top:12px;padding-bottom:12px;'>
".$pie."</td></tr>
 ";
        
        $message .= "</table>";
        
        
        
        $message .= "</body></html>";
        return $message;
    }
    public function crearCorreo($tablas, $fecha){
        //$from="Pruebas";
         $from="ALERTAS MUESMERC";
        $fromadd="alertas.postmix@muesmerc.com.mx";
        //pass a5390lert
       // $fromadd="pruebascertificacion@muesmerc.mx";
        //Recipients
        $this->mail->setFrom($fromadd, $from);
        $this->mail->addAddress($this->edestinatario, $this->destinatario);     //Add a recipient
        //Name is optional
        $this->mail->addCC($this->cc);
        
        $this->mail->isHTML(true);                                  //Set email format to HTML
        $this->mail->Subject = $this->subject;
        $this->mail->Body    = $this->crearCuerpo($tablas, $fecha);
        
        
    }
    public function agregarAdjunto($ruta_archivo){
        //Attachments
        $this->mail->addAttachment($ruta_archivo);         //Add attachments
        
    }
    public function agregarAdjuntoCadena($cadena,$nombrearchivo,$tipo){
        //Attachments
        if($tipo=="pdf"){
            $tipo='application/pdf';
        }
        $this->mail->AddStringAttachment($cadena, $nombrearchivo, 'base64', $tipo);
        
    }
    public function enviar(){
        try{
            $this->mail->send();
        }catch(Exception $ex){
            throw $ex;
        }
    }
}

