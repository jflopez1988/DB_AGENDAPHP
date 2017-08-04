<?php
  require('connector.php');
  $con = new ConectorBD($host, $user, $password);
  $response['conexion'] = $con->initConexion('agenda_db');
  if ($response['conexion']=='OK') {
    $resultado_consulta = $con->consultar('usuarios',
    'email_user','WHERE email_user="'.$_POST['username'].'"');
    //['email_user', 'pass_user'], "WHERE email_user='user@dominio.com'");
    if ($resultado_consulta->num_rows != 0) {
      $fila = $resultado_consulta->fetch_assoc();
      if (password_verify($_POST['password'], $fila['pass_user'])) {
        $response['acceso'] = 'concedido';
        session_start();
        $_SESSION['username']=$fila['email_user'];
      }else {
        $response['motivo'] = 'Contraseña incorrecta';
        $response['acceso'] = 'rechazado';
      }
    }else{
      $response['motivo'] = 'Usuario incorrecto';
      $response['acceso'] = 'rechazado';
    }
  }
  echo json_encode($response);
  $con->cerrarConexion();
 ?>
