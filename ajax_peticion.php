
<?php

if(isset($_POST['start'])){
 shell_exec("sudo -u root /sbin/service vsftpd start");
    die();  
}

if(isset($_POST['modelo'])){
include "/var/www/html/modules/Auto/template/".$_POST['modelo'].".php";
$file=trim(shell_exec('find /tftpboot -type f -name \'*.'.$suffix.'\' | wc -l'));
$f="$file $suffix";

echo json_encode(array($General,$f)); 

die();  
}

if(isset($_POST['Suffix'])){
    

    shell_exec('find /tftpboot -type f -name \'*.'.$_POST['Suffix'].'\' -delete');
    $c=trim(shell_exec('find /tftpboot -type f -name \'*.'.$_POST['Suffix'].'\' | wc -l'));

    echo json_encode(array($c,$_POST['Suffix']));
    die();  
   }

include "/var/www/html/modules/Auto/template/".$_POST['Brand'].".php"; 
Create_file($_POST['Data'],$_POST['General'],json_decode($_POST['G'],true));


?>

