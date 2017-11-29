<?php  
    //header('Content-Type: text/plain');
    //require_once "class/Empresas.php";
    require_once "class/Checklist.php";
    require_once "class/DB.php";


    //$emp = new Empresas($db);
    $check = new Checklist($db);

    $emp_datas = $check->getEmpresas();

    if(isset($_POST['submit'])) {
    
      try {
          $check->insertCheck(array(
            'che_emp_id' => $_POST['emp_id'],
            'che_nombre' => $_POST['nombre'],
            'che_activo' => $_POST['activa'],
            'che_tipo' => $_POST['tipo']
          ));
            header("Location: checklist.php");
      } catch (Exception $e) {
        die($e->getMessage());
      }
    }

    if(isset($_POST['editar'])) {
    
      try {
          $check->editCheck(array(
            'che_emp_id' => $_POST['emp_id'],
            'che_nombre' => $_POST['nombre'],
            'che_activo' => $_POST['activa'],
            'che_tipo' => $_POST['tipo']
          ), $_POST['id']);
            header("Location: checklist.php");
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

  <title>Checklist</title>

  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <script data-require="jquery@*" data-semver="2.0.3" src="assets/js/jquery-3.2.1.min.js"></script>
    <script data-require="bootstrap@*" data-semver="3.1.1" src="assets/js/bootstrap.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

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
      <a class="navbar-brand" href="#" style="color:#fff;">Checklist</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav wow">
        <li><a href="empresas.php"><font color="white">Empresas</font></a></li>
      </ul>
    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->
</nav>


<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel">
        <div class="panel-heading" style="background:#026466;">
          <h3 class="panel-title" style="color:#fff;">Lista de Checklist</h3>
        </div>
        <center style="padding-top:10px;">
          <button type="button" class="btn btn-sm" id="add_button" data-toggle="modal" data-target="#userModal" style="background:#026466;color:#fff;">Add Event</button>
        </center>

          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <th>#</th>
                <th>Nombre</th>
                <th>Empresas</th>
                <th>Activa</th>
                <th>Tipo</th>
                <th colspan="2">Action</th>
              </thead>
              <tbody>
                <?php
                  $query = "SELECT * FROM checklist INNER JOIN empresas ON (checklist.che_emp_id=empresas.emp_id)";       
                  $records_per_page=10;
                  $newquery = $check->paging($query,$records_per_page);
                  $check->checklist($newquery);
                 ?>
                 <tr>
                    <td colspan="8" align="center">
                  <div class="pagination-wrap">
                        <?php $check->paginglink($query,$records_per_page); ?>
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
        <h4 class="modal-title">Form Checklist</h4>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group" >
            <small>Nombre</small>
            <input type="text" class="form-control" name="nombre" required>
          </div>
          <div class="form-group" >
            <small>Empresas Nombre</small>
            <select class="form-control" name="emp_id" required>
              <option></option>
              <?php foreach ($emp_datas as $value): ?>
                <option value="<?php echo $value['emp_id']; ?>"><?php echo $value['emp_nombre']; ?></option>
              <?php endforeach; ?>
            </select>
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
            <small>Tipo</small>
            <select class="form-control" name="tipo" required>
              <option></option>
              <option value="0">Tipo 0</option>
              <option value="1">Tipo 1</option>
            </select>
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
        <h4 class="modal-title">Form Edit Checklist</h4>
      </div>
      <div class="modal-body">
        <form method="post">
          <div class="form-group" >
            <small>Nombre</small>
            <input type="hidden" class="form-control id" name="id">
            <input type="text" class="form-control nombre" name="nombre" required>
          </div>
          <div class="form-group" >
            <small>Empresas Nombre</small>
            <select class="form-control emp" name="emp_id" required>
              <?php foreach ($emp_datas as $value): ?>
                <option value="<?php echo $value['emp_id']; ?>"><?php echo $value['emp_nombre']; ?></option>
              <?php endforeach; ?>
            </select>
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
            <small>Tipo</small>
            <select class="form-control tipo" name="tipo" required>
              <option></option>
              <option value="0">Tipo 0</option>
              <option value="1">Tipo 1</option>
            </select>
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
                <h4 class="modal-title" id="myModalLabel">Delete Checklist</h4>
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

    var nombre = $(this).data('chenombre');
    var emp_nombre = $(this).data('empnombre');
    var emp_id = $(this).data('empid');
    var id = $(this).data('id');
    var tipo = $(this).data('chetipo');
    if(tipo == 1) {
      var tipo_text = 'Tipo 1';
    } else {
      var tipo_text = 'Tipo 0';
    }
    var activa = $(this).data('cheactivo');
    if(activa == 1) {
      var activa_text = 'Activo';
    } else {
      var activa_text = 'No Activo';
    }
    var option = $('<option value="'+emp_id+'" selected>'+emp_nombre+'</option>');
    var option2 = $('<option value="'+activa+'" selected>'+activa_text+'</option>');
    var option3 = $('<option value="'+tipo+'" selected>'+tipo_text+'</option>');

    $(".id").val(id);
    $(".nombre").val(nombre);
    $('.emp').append(option);
    $('.activa').append(option2);
    $('.tipo').append(option3);
  
});
$(".modal").on("hide.bs.modal", function(){
    location.reload();
});
$( function() {
  $( "#datepicker" ).datepicker();
});
</script>