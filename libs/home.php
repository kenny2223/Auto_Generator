<?php

include "/var/www/html/modules/Auto/template/Yealink.php"; 

$file=shell_exec('find /tftpboot -type f -name \'*.'.$suffix.'\' | wc -l');


$server=$_SERVER['SERVER_ADDR'];
$prefix=substr($server,0,strrpos($server,".")+1);
$gateway=$prefix."1";

?>

<input type="hidden" id="S_file" value="<?php echo $suffix ?>">
<div class="alert alert-success collapse" style="position: absolute;z-index: 100;" role="alert"></div>

<div class="container">
   <div class="col-sm-4 col-lg-4">
  <div class="panel panel-default">
    <div class="panel-heading">Servidor FTP</div>
    <div class="panel-body">
    <?php 
    $state=statedeamon();
    $e = ($state == "active") ? 'disabled' : '';
      echo "<label style=\"display:block;\" >Estado: ".getstate()."</label>";
     
      echo "<button type=\"button\" class=\"btn btn-success\" id=\"FTP\" $e >Activar</button>";
      ?>
    </div>
  </div>
  </div>


  <div class="col-sm-3 col-lg-3">
  <div class="panel panel-default">
    <div class="panel-heading">Cantidad de archivos en /tftpboot</div>
    <div class="panel-body">
    <?php 

    $l = ($file > 0) ? '' : 'disabled';

      echo "<label style=\"display:block;\" id=\"suffix\">$file $suffix</label>";
      echo "<button type=\"button\" class=\"btn btn-success\" id=\"D_file\" $l> Eliminar </button>";
      ?>
    </div>
  </div>
  </div>
</div>
 
<hr>
<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <textarea class="form-control" id="General" rows="50" ><?php echo $General ?></textarea>
</div>
<div class="row">
<button style="cursor:pointer;position: absolute; right:0px;" onclick="openNav()">Configuracion General&#9881;</button>
</div>
<br><br>


<div class="container">

<div class="input-group col-sm-2 col-lg-2">
<span class="input-group-addon" style="color: black;">admin</span>
<span style="position: absolute;right:0 " data-toggle="tooltip" data-placement="right" title="Password para ingresar en la web a los telefonos"  class="glyphicon glyphicon-info-sign "></span>
<input type="text" class="form-control"  style="width: 110px;" id="P_admin" placeholder="Password for Web" value="Sen31994">
</div>

  <div  class="col-sm-6  col-sm-offset-2 col-lg-6  col-lg-offset-2" style=" border: 1px none #E1E1E1; border-radius: 1em;">
  <div  class="col-sm-2 col-lg-2">
  <span  style="color: black;">Prefijo Ip</span>
  <input type="text" style="width: 120px;"  id="P_ip" value="<?php echo $prefix?>">
  </div>

  <div  class="col-sm-2 col-lg-2">
  <span  style="color: black;">Mascara</span>
  <input type="text" style="width: 120px;"  id="mask" value="255.255.255.0">
  </div>

  <div  class="col-sm-2 col-lg-2">
  <span  style="color: black;">Gateway</span>
  <input type="text" style="width: 120px;"  id="gateway" value="<?php echo $gateway?>">
  </div>
  <span  data-toggle="tooltip" data-placement="right" title="Valido solo para Ip estatica"  class="glyphicon glyphicon-info-sign "></span>
  </div>



</div>
<hr>

<div class="row">
<div class="input-group  col-sm-2 col-lg-2">
<span class="input-group-addon" style="color: black;">Fabricante</span>
<select id="Brand" class="form-control">
    <option>Yealink</option>
    <option>Grandstream</option>
  </select> 
  </div>
  <div  class=" col-sm-2 col-lg-2" style="margin-left: 5px;" >
  <span  style="color: black;">Prefijo Mac</span>
  <input type="text" maxlength="6" style="width: 80px;"  id="P_Mac" value="">
  </div>
    
</div>
  

<div class="fluid-container">
 <br><br>
<table id="my"  style='width:100%' >
   <thead>
   <?php
   
        $head=array("Name","Extension","Password","Mac Address","Conexion","IP");
        foreach ($head as  $value) {
            echo "<th>$value</th>";
        }
       
   ?>
</thead> 

<tbody >

<?php
foreach (getexts() as $k=> $v) {
      echo "<tr >";
      echo "<td ><label >{$v['Name']}</label></td>";
      echo "<td><label >{$v['Number']}</label></td>";
      echo "<td><label >{$v['Password']}</label></td>";
      echo "<td><input type=\"text\" style=\"width: 120px;\" class=\"Mac\" maxlength=\"12\" placeholder=\"\"></td>";
      echo "<td><label><input type=\"checkbox\"  id=\"checkbox\" checked>DHCP</label></td>";
     
      echo "<td><input style=\"width: 120px;\" type=\"text\" placeholder=\"\" disabled  class=\"ip\" maxlength=\"15\"></td>";
      
      echo "</tr>";
      }

      

   ?>

</tbody>
</table>
<button type="submit" id="csv" value="submitted">
<img src="modules/Auto/images/excel.gif" alt="image">
</button>

<br><br>
<input id="Server" type="hidden" value="<?php echo $server?>">

<button type="button"  class="btn btn-success" onclick="Generar()">Generar</button>





