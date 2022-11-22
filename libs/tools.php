<?php

function getexts(){

global $arrConf;
$pDB = new paloDB($arrConf['Conn_database']);
$DB_users=$pDB->fetchTable("SELECT *  FROM asterisk.users", true);


if (count($DB_users) > 0) {  
$Ext_name = array_map(function ($e) {return $e['extension'];},$DB_users);

$Data = file_get_contents('/etc/asterisk/sip_additional.conf');
$arraydata = explode("\n\n", $Data);

foreach ($arraydata as $line) {

        if (preg_match('/\[\d*\]/', $line,$match)) {
        
                $split=preg_split('/\s+/', $line);

                foreach ($split as $value) {
                if (preg_match('/secret/', $value)) list($k,$v)=explode("=",$value);
   
                }
                $number=str_replace( array('[',']') , ''  , $match[0]);
                
               $index= array_search($number, $Ext_name);
                $Exts[]=array("Number"=>$number,"Password"=>$v,"Name"=> $DB_users[$index]['name']);
          
        }
}
}

return isset($Exts) ? $Exts : array();
}


function getstate(){
$status = statedeamon();

if ($status=="active") $S="<span style=\"color:green;font-weight:bold\">Activo</span>";
else $S= "<span style=\"color:red;font-weight:bold\">Desactivo</span>";
return $S;
}

function statedeamon(){
return trim(shell_exec('systemctl status vsftpd | grep Active: | awk \'{print $2}\''));  
}




?>