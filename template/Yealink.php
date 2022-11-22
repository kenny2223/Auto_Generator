<?php

$suffix="cfg";
  function Create_file($data,$General,$G){

  foreach ($data as $k => $v) {

if ($v[4] == "false") {
$network= <<<"n"
network.internet_port.type = 2

# Direccion IP
network.internet_port.ip = $v[5]

# Mascara de red
network.internet_port.mask = {$G["mask"]}

# gateway de red
network.internet_port.gateway = {$G["gateway"]}
n;
}else $network="network.internet_port.type = 0";

$text= <<<"format"
#!version:1.0.0.1
## the file header "#!version:1.0.0.1" can not be edited or deleted. ##
#  Script Created by Mario Ruiz in VB passed to web by Ing.Kenny Ortiz
account.1.enable = 1
account.1.label = {$v[1]}
account.1.display_name = {$v[0]}
account.1.auth_name = {$v[1]}
account.1.user_name = {$v[1]}
account.1.password = {$v[2]}
        
# Parametro DHCP
{$network}
      
security.user_password =  admin:{$G["P_admin"]}
      
account.1.sip_server.1.address = {$G["Server"]}

#      Servidor NTP
local_time.ntp_server1 = {$G["Server"]}

{$General}
        
format;


  file_put_contents("/tftpboot/$v[3].cfg",$text);
      
  }

}


$General= <<<"G"
##################################################
#          OTRAS CONFIGURACIONES                 #
##################################################

# Parametros de VLAN 
network.vlan.internet_port_enable = 0
network.vlan.internet_port_vid  = 0


#      Parametros de Fecha y Hora
local_time.date_format = 1
local_time.summer_time = 2
local_time.time_format = 0
local_time.time_zone = -6
local_time.time_zone_name = Nicaragua                                                                                                                           



#      Tecla de Agenda 
programablekey.2.type = 38
programablekey.2.label = Agenda

#      Codec de Cuenta1
account.1.enable = 1
account.1.codec.pcmu.priority = 1
account.1.codec.pcma.priority = 2
account.1.codec.g729.enable = 0
account.1.codec.g729.priority = 0
account.1.codec.g722.enable = 0
account.1.codec.g722.priority = 0


#      Idioma y tonos
lang.gui = Spanish
lang.wui = Spanish
voice.tone.country = Germany
phone_setting.backlight_time = 15

#      Bloqueo de Factory Reset
features.factory_pwd_enable = 1

#      Configuraciones de Agenda
remote_phonebook.data.1.name = Agenda
programablekey.2.type = 22
programablekey.2.line = 1
programablekey.2.label = Agenda


G;
?>