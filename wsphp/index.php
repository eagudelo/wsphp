<?php
    session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="estilos/estilo1_sbi.css" rel="stylesheet" type="text/css" />
		<title>Bienvenido al sitio de Soluciones Buenas Ideas</title>
	</head>
	<body>
		<h1>Bienvenido a Soluciones Buenas Ideas</h1>
		<?php
		  include_once('utiles/configuracion.php');
          echo '<br/>Prueba<br/>';
		  $objConf = new CConfigura('txt_cfg/configuracion.txt');
          echo '<br/>Prueba<br/>';
          echo '<br/>'. $objConf->getHabilitado() .'<br/>';
          if($objConf->getHabilitado() == 1){
              echo '<br/>Esta habilitado<br/>';
          }
          else{
          	echo '<br/>Esta inhabilitado<br/>';
          }
		?>
	</body>
</html>

