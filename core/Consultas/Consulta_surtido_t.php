<?php session_start();
if(!isset($_SESSION['id_usuario']))
	header('Location: ../../index.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Surtido Desactivado a Tiempo</title>
	<link rel="stylesheet" href="../../css/normalize.css">
	<link rel="stylesheet" href="../../css/materialize.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" type="text/css" href="../../fonts/icons/material-icons.css">
	<script type="text/javascript" src="../../js/jquery.js"></script>
	<script type="text/javascript" src="../../js/materialize.js"></script>
	<script type="text/javascript" src="../../js/jquery.validate.js"></script>
	<script type="text/javascript" src="../../js/jspdf.js"></script>
	<script type="text/javascript" src="../../js/pdfFromHTML.js"></script>
</head>

<script type="text/javascript">
	$(document).ready(function(){
		$('.datepicker').datepicker({
				format:'yyyy-mm-dd'
			});	
	
	});

		
		function buscar_corte(par,par2)
		{
			$.post("controller_consulta.php",{action:"buscar_Bvc",par:par,par2:par2}, function(res)
			{
				$("#content_table_ventas").html(res);

			});
		}
		$(document).on('change','.busc',function()
		{
				var bu1=$("#busc1").val();
				var bu2=$("#busc2").val();
				
				if (bu1!="" && bu2!="")
				{
					buscar_corte(bu1,bu2);
				}
				else
				{
					get_all_corte();
				}
		});

		function Imprimir()
		{
			window.print();
		}

		
</script>
<body>
	<section class="container" id="HTMLtoPDF">
		<div class="card-panel z-depth-3 grey lighten-2">
			
			<h4 class="center">Surtido desactivado a tiempo</h4>
			<div class="container row">
				<div class="col s4 offset-s2">
					<label class="labelCorte">
						<h6>Fecha de Inicio</h6>
					</label>
					<br>
					<div id="fecha_ini">
						<input type="text" id="busc1" name="busc1" class="datepicker busc"  placeholder="Buscar por Fecha" style="width: 60%;">
					</div>
				</div>

				<div class="col s4 offset-s2">
					<label class="labelCorte">
						<h6>Fecha de Corte</h6>
					</label>
					<br>
					<div id="fecha_cor">
						<input type="text" id="busc2" name="busc2" class="datepicker busc"  placeholder="Buscar por Fecha" style="width: 60%;">
					</div>
				</div>

				<label class="col s12 center labelCorte"> 
					<h6>Productos venditos</h6>
				</label>
				<table class="table responsive-table bordered ">
					<tr>
						<th>Numero de Surtido</th>
						<th>Ingrediente</th>
						<th>Cantidad Ingresada</th>
						<th>Fecha de Entrada</th>
						<th>Fecha de Caducidad</th>
						<th>Proveedor</th>
					</tr>
					<tbody id="content_table_ventas">
					
					</tbody>
				</table>
			
			</div>
			<a class="waves-effect waves-light btn red" style="position: relative; left: 90%;" onclick="Imprimir()">Imprimir</a>
		</div>
	</section>
	
</body>
</html>