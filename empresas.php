<?php  
  
    require_once "class/Empresas.php";
    require_once "class/DB.php";


    $emp = new Empresas($db);

    if(isset($_POST['submit'])) {
    
      try {
          $emp->insertEmp(array(
            'emp_nombre' => $_POST['nombre'],
            'emp_fecha_alta' => $_POST['datepicker'],
            'emp_activa' => $_POST['activa'],
            'usu_clave' => $_POST['usu_clave']
          ));
            header("Location: empresas.php");
      } catch (Exception $e) {
        die($e->getMessage());
      }
    }

    if(isset($_POST['editar'])) {
    
      try {
          $emp->editEmp(array(
            'emp_nombre' => $_POST['nombre'],
            'emp_fecha_alta' => $_POST['datepicker'],
            'emp_activa' => $_POST['activa'],
            'usu_clave' => $_POST['usu_clave']
          ), $_POST['id']);
            header("Location: empresas.php");
      } catch (Exception $e) {
        die($e->getMessage());
      }
    }

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

  <title>Empresas</title>

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <script data-require="jquery@*" data-semver="2.0.3" src="assets/js/jquery-3.2.1.min.js"></script>
    <script data-require="bootstrap@*" data-semver="3.1.1" src="assets/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>

<nav class="navbar navbar-default" style="background:#026466;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#" style="color:#fff;">Empresas</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav wow">
        <li><a href="checklist.php"><font color="white">Checklist</font></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->
</nav>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel">
        <div class="panel-heading" style="background:#026466;">
          <h3 class="panel-title" style="color:#fff;">Lista de empresas</h3>
        </div>
        <center style="padding-top:10px;">
          <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#myModal" style="background:#026466;color:#fff;">Add Empresas</button>
        </center>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <th>#</th>
                <th>Nombre</th>
                <th>Fecha Alta</th>
                <th>Activa</th>
                <th>Usu Clave</th>
                <th colspan="2">Action</th>
              </thead>
              <tbody>
                <?php
                  $query = "SELECT * FROM empresas";       
                  $records_per_page=10;
                  $newquery = $emp->paging($query,$records_per_page);
                  $emp->empresaslist($newquery);
                 ?>
                 <tr>
                    <td colspan="8" align="center">
                  <div class="pagination-wrap">
                        <?php $emp->paginglink($query,$records_per_page); ?>
                      </div>
                    </td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Form Empresas</h4>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group" >
            <small>Nombre</small>
            <input type="text" class="form-control" name="nombre" required>
          </div>
          <div class="form-group" >
            <small>Fecha Alta</small>
            <input type="text" class="form-control" id="datepicker" name="datepicker" required>
          </div>
          <div class="form-group" >
            <small>Activa</small>
            <select class="form-control" name="activa" required>
              <option></option>
              <option value="1">Activo</option>
              <option value="0">No Activo</option>
            </select>
          </div>
          <div class="form-group" >
            <small>Usu Clave</small>
            <input type="text" class="form-control" name="usu_clave" required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="submit" class="btn btn-success btn-sm">Submit</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        </form>
      </div>
    </div>

  </div>
</div>

<!-- Modal Edit-->
<div id="myModalEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">form editar empresas</h4>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group" >
            <small>Nombre</small>
            <input type="hidden" class="form-control id" name="id">
            <input type="text" class="form-control nombre" name="nombre" required>
          </div>
          <div class="form-group" >
            <small>Fecha Alta</small>
            <input type="text" class="form-control fecha" id="datepicker2" name="datepicker" required>
          </div>
          <div class="form-group" >
            <small>Activa</small>
            <select class="form-control activa" name="activa" required>
              <option></option>
              <option value="1">Activo</option>
              <option value="0">No Activo</option>
            </select>
          </div>
          <div class="form-group" >
            <small>Usu Clave</small>
            <input type="text" class="form-control usu" name="usu_clave" required>
          </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="editar" class="btn btn-success btn-sm">Submit</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        </form>
      </div>
    </div>

  </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Empresas</h4>
            </div>
        
            <div class="modal-body">
                <p>Are you sure ..?</p>
                <p class="debug-url"></p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    $(this).find('.btn-ok').attr('nombre', $(e.relatedTarget).data('nombre'));
    
    $('.debug-url').html('Delete : <strong>' + $(this).find('.btn-ok').attr('nombre') + '</strong>');

});
</script>
<script>
$(document).on( "click", '.edit_button',function(e) {
    var nombre = $(this).data('nombre');
    var fecha = $(this).data('fecha');
    var usu = $(this).data('usu');
    var activa = $(this).data('activa');
    if(activa == 1) {
      var activa_text = 'Activo';
    } else {
      var activa_text = 'No Activo';
    }
    var id = $(this).data('id');
    var option = $('<option value="'+activa+'" selected>'+activa_text+'</option>');

    $(".id").val(id);
    $(".nombre").val(nombre);
    $(".fecha").val(fecha);
    $(".usu").val(usu);
    $('.activa').append(option); 
});
$(".modal").on("hide.bs.modal", function(){
    location.reload();
});
$(function() {
  $("#datepicker").datepicker({dateFormat: 'yy-mm-dd'});
});
$(function() {
  $("#datepicker2").datepicker({dateFormat: 'yy-mm-dd'});
});
</script>