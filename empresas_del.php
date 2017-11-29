<?php  
  
    require_once "class/Empresas.php";
    require_once "class/DB.php";


    $emp = new Empresas($db);

    if(isset($_REQUEST['id'])) {

      try {
          $emp->delEmp($_REQUEST['id']);
          header("Location: empresas.php");
      } catch (Exception $e) {
          die($e->getMessage());
      }
  }

?>