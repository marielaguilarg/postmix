<?php
include "correo.php";
class EnviarCertificado{
    //crear el pdf
    public $numreporte;
    public $servicio;
    public $listaCorreos;
    
    public function enviarAlerta(){
        $this->buscarCorreos();
        /****rehaciendo la funcion de imprimirCertificado
        $doc = $pdf->Output('S');
        $mail->AddStringAttachment($doc, 'doc.pdf', 'base64', 'application/pdf');*/
        /**** o haciendo la peticion a mi mismo*/
        $nombrearchivo="pruebapdf.pdf";
        $url="http://localhost/postmix/imprimirReporte.php?admin=impcerpm&sv=".$this->servicio."&nrep=".$this->numreporte;
        $paginacert = file_get_contents($url);
        $envio=new Correo();
        $asunto="Alerta auditoria postmix";
        $body="Este correo es para informarle los resultados de la auditoria postmix que se adjuntan en el archivo pdf";
        
        $edestinatario=$this->listaCorreos["correo"];
        $destinatario=$this->listaCorreos["nombre"];
        $copia=$this->listaCorreos["cc"];
        $envio->crearCorreo($edestinatario, $destinatario, $copia,$asunto,$body);
       
        $envio->agregarAdjuntoCadena($paginacert,$nombrearchivo,"pdf");
        $envio->enviar();
     }
    /*** devuelve los correos a los que se envia**/
    public function buscarCorreos($numreporte,$servicio){
        //buscar la direccion a la que se enviará x región
        //un inner join del reporte y los correos por region
        
        
        
    }
}