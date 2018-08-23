<!DOCTYPE html>
<html>
<head>
	<title>Consulta de Corte de Caja</title>
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

		get_all_corteVenta();
		get_all_corteV();
	});

	function get_all_corteV()
		{
			var id_corte=$("#id_corte").val();

			$.post("controller_consulta.php",{action:"get_all_CorteE","id_corte":id_corte},
			function(res)
			{
				var datos=JSON.parse(res);
				var fi="";
				var fc="";
				var ci="";
				var ce="";
				var cc="";
				var ts="";
				var g="";
				var u="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					fi+="<input type='text' disabled='disabled' name='' value="+info['fecha_inicio']+">";
					fc+="<input type='text' disabled='disabled' name='' value="+info['fecha_corte']+">";
					ci+="<input type='text' disabled='disabled' name='' value="+info['cantidad_i']+">";
					ce+="<input type='text' disabled='disabled' name='' value="+info['c_efectivo']+">";
					cc+="<input type='text' disabled='disabled' name='' value="+info['c_credito']+">";
					ts+="<input type='text' disabled='disabled' name='' value="+info['total_c']+">";
					g+="<input type='text' disabled='disabled' name='' value="+info['ganancia']+">";
					u+="<input type='text' disabled='disabled' name='' value="+info['nombre']+">";
					//se insertan los datos a la tabla
				}
				$("#fecha_ini").html(fi);
				$("#fecha_cor").html(fc);
				$("#can_ini").html(ci);
				$("#can_efe").html(ce);
				$("#can_cre").html(cc);
				$("#tot_s").html(ts);
				$("#gan").html(g);
				$("#usu").html(u);
			});
		}

		function get_all_corteVenta()
		{
			var fecha_inicio=$("#fecha_inicio").val();
			var fecha_corte=$("#fecha_corte").val();

			$.post("controller_consulta.php",{action:"get_all_CorteV",fecha_inicio:<?php echo $_GET["fecha_inicio"];?>,fecha_corte:<?php echo $_GET["fecha_corte"];?>},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					cod_html+="<tr><td>"+info['cu']+"</td><td>"+info['desi']+"</td><td>"+info['cantidad']+"</td><td>"+info['precio']+"</td><td>"+info['subtotal']+"</td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table_ventas").html(cod_html);
				
			});
		}

		function Imprimir()
		{
			window.print();
		}

		
</script>
<body>
	<section class="container" id="HTMLtoPDF">
		<div class="card-panel z-depth-3 grey lighten-2">
			<?php
        		if(isset($_GET["id_corte"]))
        		echo '<input value="'.$_GET["id_corte"].'"id="id_corte" name="id_corte" type="hidden">';
        	?>

        	<?php
        		if(isset($_GET["fecha_inicio"]))
        		echo '<input value="'.$_GET["fecha_inicio"].'" id="fecha_inicio" name="fecha_inicio" type="hidden">';
        	?>

        	<?php
        		if(isset($_GET["fecha_corte"]))
        		echo '<input value="'.$_GET["fecha_corte"].'" id="fecha_corte" name="fecha_corte" type="hidden">';
        	?>
			<h4 class="center">Corte de Caja</h4>
			<div class="container row">
				<div class="col s4 offset-s2">
					<label class="labelCorte">
						<h6>Fecha de Inicio</h6>
					</label>
					<br>
					<div id="fecha_ini">
						
					</div>
				</div>

				<div class="col s4 offset-s2">
					<label class="labelCorte">
						<h6>Fecha de Corte</h6>
					</label>
					<br>
					<div id="fecha_cor">
						
					</div>
				</div>

				<div class="col s3 offset-s1">
					<label class="labelCorte">
						<h6>Cantidad Inicial</h6>
					</label>
					<br>
					<div id="can_ini">
						
					</div>
				</div>
				
				<div class="col s3 offset-s1">
					<label class="labelCorte">
						<h6>Cantidad en Efectivo</h6>
					</label>
					<br>
					<div id="can_efe">
						
					</div>
				</div>

				<div class="col s3 offset-s1">
					<label class="labelCorte">
						<h6>Cantidad en Credito</h6>
					</label>
					<br>
					<div id="can_cre">
						
					</div>
				</div>
				<label class="col s12 center labelCorte"> 
					<h6>Productos venditos</h6>
				</label>
				<table class="table responsive-table bordered ">
					<tr>
						<th>Cuenta</th>
						<th>Descripcion</th>
						<th>Cantidad</th>
						<th>Precio</th>
						<th>Subtotal</th>
					</tr>
					<tbody id="content_table_ventas">
					
					</tbody>
				</table>
				<div class="col s3 offset-s1">
					<label class="labelCorte">
						<h6>Total en el Sistema</h6>
					</label>
					<br>
					<div id="tot_s">
						
					</div>
				</div>
				
				<div class="col s3 offset-s1">
					<label class="labelCorte">
						<h6>Ganancia</h6>
					</label>
					<br>
					<div id="gan">
						
					</div>
				</div>

				<div class="col s3 offset-s1">
					<label class="labelCorte">
						<h6>Usuario</h6>
					</label>
					<br>
					<div id="usu">
						
					</div>
				</div>
			</div>
			<a class="waves-effect waves-light btn red" style="position: relative; left: 90%;" onclick="Imprimir()">Imprimir</a>
		</div>
	</section>
	
</body>
</html>