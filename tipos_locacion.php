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
	<title>Tipos de Locaciones</title>
	<script type="text/javascript">
		$(document).ready(function()
		{
			$("#alerta").on("click",function(){
				get_all_i();
			});
			get_all();
			$("#add_t_l").click(function()
			{
				$("#container_modal").load("core/Tipos_locaciones/form_t_l.php");
			});

			$("#content_table").on("click","a.btn_eliminar",function(){
				$("#Modal_confirm_deleteTl").modal();
				$("#Modal_confirm_deleteTl").modal("open");
				$("#btn_confirm_deleteTl").data("id",$(this).data("id"));
			});
			$("#content_table").on("click","a.btn_modificar",function(){
				var id_tipo_l=$(this).data("id");
				$("#container_modal").load("core/Tipos_locaciones/form_t_l_u.php?id_tipo_l="+id_tipo_l);
			});

		});
		function get_all()
		{

			$.post("core/Tipos_locaciones/controller_t_l.php",{action:"get_all"},
			function(res)
			{
				var datos=JSON.parse(res);
				var cod_html="";
				for (var i=0;i<datos.length;i++) 
				{
					var info=datos[i];
					cod_html+="<tr><td>"+info['descripcion']+"</td><td class='centrado'><a class='waves-effect btn-flat btn_eliminar' data-id='"+info["id_tipo_l"]+"' style='color: #ef5350'><span class='material-icons' style='margin-top: 0.2em'>cancel</span></a></td><td class='centrado'><a class='waves-effect btn-flat btn_modificar' data-id='"+info["id_tipo_l"]+"' style='color: #1976d2'><span class='material-icons' style='margin-top: 0.2em'>edit</span></a></td></tr>";
					//se insertan los datos a la tabla
				}
				$("#content_table").html(cod_html);
				
			});
			$("#btn_confirm_deleteTl").click(function(event){
				var id_tipo_l=$(this).data("id");
				$.post("core/Tipos_locaciones/controller_t_l.php",{action:'delete',id_tipo_l:id_tipo_l},
					function(){
						get_all();
						$("#Modal_confirm_deleteTl").modal("close");
					});
			});
		}
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
				<div class="text-center">
					<a class="waves-effect waves-teal btn green modal-trigger tooltipped"  data-position="right" data-tooltip="Agregar Tipo de Loacion" style="width: 2em;height: 2em;padding: 0.2em;float: right;" href="#container_modal"  id="add_t_l"><span class="material-icons">add</span></a>
					<h4>Tipos de Locaciones</h4>
				</div>
				<div>
					 <table class="table responsive-table bordered">
					 	<tr>
					 		<th>Descripcion</th>
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

	<div class="modal" id="Modal_confirm_deleteTl" tabindex="-1"> 
		<div class="modal-content"> 
		<div class="modal-body">
			 ¿Seguro que desea eliminar el registro?		
		</div>
		<div class="modal-footer"> 
		<button type="button" class="btn modal-action modal-close red">Cancelar</button> 
		<input  type="button" class="btn blue" id="btn_confirm_deleteTl" value="Aceptar">
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