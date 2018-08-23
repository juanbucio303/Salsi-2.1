<?php session_start();
if(!isset($_SESSION['id_usuario']))
	header('Location: index.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device‐width, initial‐scale=1.0"> 
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/materialize.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="fonts/icons/material-icons.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/materialize.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<title>Descuentos</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$("#alerta").on("click",function(){
				get_all_i();
			});
			get_all();
			$("#add_descuentos").click(function()
			{
				$("#container_modal").load("core/Descuentos/form_descuentos.php");
			});
///////////////////////////////////////////////////////////////////////////////////////////
			$("#content_table").on("click","a.btn_eliminar",function(){
				$("#Modal_confirm_deleteD").modal();
				$("#Modal_confirm_deleteD").modal('open');
				$("#btn_confirm_deleteD").data("id",$(this).data("id"));
			});
			$("#btn_confirm_deleteD").click(function(event){
				var id_descuento=$(this).data("id");
				$.post("core/Descuentos/controller_descuentos.php",{action:'delete',id_descuento:id_descuento},
					function(){
						get_all();
						$("#Modal_confirm_deleteD").modal("close");
					});
			});
/////////////////////////////////////////////////////////////////////////////////////////	
			$("#content_table").on("click","a.btn_modificar",function(){
				var id_descuento=$(this).data("id");
				$("#container_modal").load("core/Descuentos/form_descuentos_u.php?id_descuento="+id_descuento);
			})

		});
/////////////////////////////////////////////////////////////////////////////////////////		
		function get_all()
		{
			$.post("core/Descuentos/controller_descuentos.php",{action:"get_all"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					cod_html+="<tr><td>%"+info['monto']+"</td><td class='centrado'><a class='waves-effect btn-flat btn_eliminar' data-id='"+info["id_descuento"]+"'><span class='material-icons' style='color: #ef5350'>cancel</span></a></td><td class='centrado'><a class='waves-effect btn-flat  btn_modificar' style='color: #1976d2' data-id='"+info["id_descuento"]+"'><span class='material-icons'>edit</span></a></td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);	
			});
		}

		function buscar_d(consulta)
		{
			$.post("core/Descuentos/controller_descuentos.php",{action:"buscar",consulta:consulta}, function(res)
			{
				$("#content_table").html(res);

			});
		}
		$(document).on('keyup','#busc',function()
		{
				var da=$(this).val();
				if (da!="")
				{
					buscar_d(da);
				}
				else
				{
					get_all();
				}
		});
	</script>
</head>
<body>
	<!--SE MANDA A LLAMAR EL MENU PARA QUE SEA UN NAV BAR-->
	<div style="background-color: #5C5757;" class="align-centerx">
		<?php
			require_once("menu.php");
		?>
	</div>
	<section class="container">
		
		<div class="card-panel z-depth-3 grey lighten-2">
			<div class="container">
				<div class="input-field align-center">
					<input type="text" id="busc" name="busc"  class="form-control bus" placeholder="Buscar por Porcentaje de Descuento">
					<label for="busc">Buscar</label>
				</div>
			<div class="text-center">
				<a class="waves-effect waves-teal btn green modal-trigger tooltipped" data-position="right" data-tooltip="Agregar % de Descuento" style="width: 2em;height: 2em;padding: 0.2em;float: right;" href="#!"  id="add_descuentos"><span class="material-icons">add</span></a>
				<h4>Descuentos</h4>
			</div>
				<div class="panel">
					 <table class="table responsive-table bordered">
					 	<tr>
					 		<th>Porcentaje</th>
					 		<th class="centrado">Eliminar</th>
					 		<th class="centrado">Editar</th>
					 	</tr>
					 	<tbody id="content_table"></tbody>
					 	
					 </table>
				</div>
			</div>
		</div>
		<?php
			require_once("boton.php");
		?>
	</section>
	<aside id="container_modal">
	</aside>

	<div class="modal fade" id="Modal_confirm_deleteD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog"> 
		<div class="modal-content"> 


			<div class="modal-header">  
				<h4 class="modal-title" id="myModalLabel">
				</h4> <!-- se especifica el titulo del modal para diferenciarlos-->
			</div >
			<div class="modal-body">
				 Seguro que desea eliminar el registro		
			</div>
			<div class="modal-footer"> 
			<input type="button" class="waves-effect waves-light btn modal-action modal-close red"" data-dismiss="modal" value="Cerrar"> 	
			<input  type="button" class="btn blue" id="btn_confirm_deleteD" value="Aceptar">

		</div > 
	</div > 
</div >
</body>
<style type="text/css">
	table tr:hover
	{
		background-color: lightgray;
	}
	table .centrado
	{
		text-align: center;
	}
	table tr td
	{
		padding: 0em;
	}
</style>
</html>