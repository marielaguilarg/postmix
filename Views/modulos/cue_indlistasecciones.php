<?php

 switch (filter_input(INPUT_GET, "tiposec",FILTER_SANITIZE_STRING)){
     case "A" : include('views/modulos/cue_indconsultaabierta.php');
     break;
     case "AD":include("views/modulos/cue_indconsultaabiertadetalle.php");
     break;
     case "V" : include('views/modulos/cue_indconsultaproducto.php');
     break;
     case "E" : include('views/modulos/cue_indconsultaestandar.php');
     break;
     case "ED" : include('views/modulos/cue_indconsultaestandardetalle.php');
     break;
     case "P" : include('views/modulos/cue_indconsultaponderada.php');
     break;
     case "C" :
         include  "Controllers/indpostmix/consultaComentPonderado.php";
         $comentController=new ConsultaComentPonderado();
         $comentController->vistaComentPonderado();
         include('views/modulos/cue_indconsultacomentario.php');
     break;
     case 'img':	include('views/modulos/cue_indconsultaimagen.php');
     break;
     case "coment" :
         include  "Controllers/indpostmix/consultaComentPonderado.php";
         $comentController=new ConsultaComentPonderado();
         $comentController->vistaSeccionComentario();
         include('views/modulos/cue_indconsultacomentario.php');
         break;
     case "datos" :
         include('views/modulos/cue_indconsultageneral.php');
         break;
 }

