<?php

header("Content-Type: application/csv");
header("Content-disposition: filename=Extensiones.csv");
      
     
        $a = (array)json_decode($_GET['head']);
        $data = (array)json_decode($_GET['data']);

        $fp = fopen("php://output", 'w');
        fputcsv($fp,$a);
        
        foreach ($data as $key => $value) {
            fputcsv($fp, $value);
      } 
      
        fclose($fp);


?>
