   <?php
   $suffix="xml";
  function Create_file($data,$General,$G){

  foreach ($data as $k => $v) {
if ($v[4] == "false") {
$ip=explode(".", $v[5]);
$mask=explode(".", $G["mask"]);
$gateway=explode(".", $G["gateway"]);
$network= <<<"n"

    <P8>1</P8>

    <!--Direccion IP-->
    <P9>{$ip[0]}</P9>
    <P10>{$ip[1]}</P10>
    <P11>{$ip[2]}</P11>
    <P12>{$ip[3]}</P12>

    <!--Mascara-->
    <P13>{$mask[0]}</P13>
    <P14>{$mask[1]}</P14>
    <P15>{$mask[2]}</P15>
    <P16>{$mask[3]}</P16>

    <!--Gateway-->
    <P17>{$gateway[0]}</P17>
    <P18>{$gateway[1]}</P18>
    <P19>{$gateway[2]}</P19>
    <P20>{$gateway[3]}</P20>

n;
}else $network="<P8>0</P8>";


    $text= <<<"format"
<?xml version="1.0" encoding="UTF-8" ?>
<!-- Grandstream XML Provisioning Configuration - Script Created by Mario Ruiz in VB passed to web by Ing.Kenny Ortiz-->
<gs_provision version="1" >
<mac>{$v[3]}</mac>
  <config version="1" >
    <!--Cuenta a Registrar-->
    <P270>1</P270>
    <P270>{$v[1]}</P270>
    <P3>{$v[0]}</P3>
    <P35>{$v[1]}</P35>
    <P36>{$v[1]}</P36>
    <P34>{$v[2]}</P34>

    <!--Configuracion de DHCP-->
    {$network}


    <!-- SIP Server -->
    <P47>{$G['Server']}</P47>

    <!-- Configuracion de NTP-->
    <P30>{$G['Server']}</P30>

    <!-- Password para admin-->
    <P2>{$G["P_admin"]}</P2>

      {$General}
  </config>
</gs_provision>

format;

file_put_contents("/tftpboot/cfg$v[3].xml",$text);
  }
}


$General= <<<"G"
<!--# OTRAS CONFIGURACIONES #-->

    <!-- Servidor Secundario -->
    <P2312></P2312>

    <!--VLAN ID-->
    <P51>0</P51>

    <!-- NTP Secundario -->
    <P8333></P8333>
    
    <!-- Formato Fecha  -->
    <P64>CST+6</P64>
  
    <!-- Idioma -->
    <P1362>es</P1362>
  
    <!-- Transferencia Atendida-->
    <P1376>1</P1376>

  
G;




?>