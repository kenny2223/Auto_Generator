<?php

function _moduleContent(&$smarty,$module_name)
{  

/*
  spl_autoload_register(function ($clase) use ($module_name) {
    include_once "modules/$module_name/libs/" . $clase . '.php';
});
*/

  include_once "modules/$module_name/configs/default.conf.php";
  include_once "modules/$module_name/libs/tools.php";

  global $arrConf;
  global $arrConfModule;
  $arrConf = array_merge($arrConf,$arrConfModule);

ob_start();
include("modules/$module_name/libs/home.php");
$view = ob_get_contents();
ob_end_clean();
session_write_close();

return  $view;
}


?>
