<?php session_start();
if(!isset($_SESSION['id_usuario']))
	header('Location: index.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device‐width, initial‐scale=1.0"> 
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" href="css/materialize.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="fonts/icons/material-icons.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.es.js"></script>

	

	<title>Consultas</title>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#alerta").on("click",function(){
				get_all_i();
			});

			$('.datepicker').datepicker({
				format:'yyyy-mm-dd'
			});	
			
			$("#cor").click(function(){
					$("#container_modal").load("core/Consultas/form_corte.php");
			});
			$("#Bvm").click(function(){
					window.open("core/Consultas/Consulta_corte_g.php");
			});
			$("#Bvc").click(function(){
					window.open("core/Consultas/Consulta_surtido_t.php");
			});
			$("#Bcm").click(function(){
					window.open("core/Consultas/Consulta_surtido_f_t.php");
			});
			$("#Bcc").click(function(){
					window.open("core/Consultas/Consulta_productos_c.php");
			});

		});
	</script>
</head>
<body>
	<!--SE MANDA A LLAMAR EL MENU PARA QUE SEA UN NAV BAR-->
	<div style="background-color: #5C5757;" class="align-centerx">
		<?php
			require_once("menu_v.php");
		?>
	</div>
<br> 
	<div class="container">
		<div class="row" id="divp" style="border:solid #DDDDDD;">
				<div class="col s12" style="background: #F5F5F5;">
					<center><h1>Consultas</h1></center>	
				</div>

					<div class="col s12" style="background:white;">
						<br>

						<div class="col s4 offset-s0" style="border:solid #DDDDDD;"><center><h5 class="panel-title">Bitacoras de Corte de Caja por dia</h5></center>
							<div class="panel-body">
								<a href="#!" id="cor" class="data-toggle=" data-target="#exampleModal""><center><span class="material-icons">search</center></span></a>
							</div>
						</div>
						
						<div class="col s4 offset-s0" style="border:solid #DDDDDD;"><center><h5 class="panel-title">Ventas por Fechas</h5></center>
							<div class="panel-body">
								<a href="#!" id="Bvm" class="data-toggle=" modal" data-target="#exampleModal""><center><span class="material-icons">search</center></span></a>
							</div>
						</div>
						
						<div class="col s4 offset-s0" style="border:solid #DDDDDD;"><center><h5 class="panel-title">Surtido Desactivado a Tiempo</h5></center>
							<div class="panel-body">
								<a href="#!" id="Bvc" class="data-toggle=" modal" data-target="#exampleModal""><center><span class="material-icons">search</center></span></a>
							</div>
						</div>

						<br><br><br><br><br><br><br>

						<div class="col s4" style="border:solid #DDDDDD;"><center><h5 class="panel-title">Surtido Fuera de Tiempo</h5></center>
							<div class="panel-body">
								<a href="#!" id="Bcm" class="data-toggle=" modal" data-target="#exampleModal""><center><span class="material-icons">search</center></span></a>
							</div>
						</div>
						
						<div class="col s4" style="border:solid #DDDDDD;"><center><h5 class="panel-title">Bitacora de Productos Cancelada</h5></center>
							<div class="panel-body">
								<a href="#!" id="Bcc" class="data-toggle=" modal" data-target="#exampleModal""><center><span class="material-icons">search</center></span></a>
							</div>
						</div>
						<div class="col s12">
							<br>
						</div>
					</div>
					<?php
						require_once("boton.php");
					?>
		</div>
	</div>

	<div id="container_modal" class="modal">

  	</div>
</body>
</html>