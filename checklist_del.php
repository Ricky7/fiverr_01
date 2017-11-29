<?php  
  
    require_once "class/Checklist.php";
    require_once "class/DB.php";


    $check = new Checklist($db);

    if(isset($_REQUEST['id'])) {

      try {
          $check->delCheck($_REQUEST['id']);
          header("Location: checklist.php");
      } catch (Exception $e) {
          die($e->getMessage());
      }
  }

?>